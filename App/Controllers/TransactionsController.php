<?php

namespace App\Controllers;

use App\DAO\TransactionDAO;
use App\DAO\UsersDAO;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class TransactionsController
{
    public function create(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $userId = $data['user_id'] ?? null;
        $type   = $data['type'] ?? null;
        $amount = $data['amount'] ?? null;

        if (!$userId || !$type || !$amount) {
            return $this->json($response, ['error' => 'Campos obrigatórios: user_id, type, amount.'], 400);
        }

        if (!in_array($type, ['deposit', 'withdraw'])) {
            return $this->json($response, ['error' => 'Tipo inválido. Use deposit ou withdraw.'], 400);
        }

        $usersDAO = new UsersDAO();
        $user = $usersDAO->getUserById($userId);

        if (!$user) {
            return $this->json($response, ['error' => 'Usuário não encontrado.'], 404);
        }

        if ($type === 'deposit') {
            $user->balance += $amount;
        } elseif ($type === 'withdraw') {
            if ($user->balance < $amount) {
                return $this->json($response, ['error' => 'Saldo insuficiente.'], 400);
            }
            $user->balance -= $amount;
        }
        $user->save();

        $dao = new TransactionDAO();
        $transaction = $dao->createTransaction([
            'user_id' => $userId,
            'type'    => $type,
            'amount'  => $amount
        ]);

        return $this->json($response, [
            'message' => 'Transação registrada com sucesso.',
            'transaction' => $transaction
        ], 201);
    }

    public function listByUser(Request $request, Response $response, array $args): Response
    {
        $userId = (int) $args['id'];

        $dao = new TransactionDAO();
        $transactions = $dao->getTransactionsByUserId($userId);

        return $this->json($response, $transactions);
    }

    private function json(Response $response, $data, int $status = 200): Response
    {
        $response->getBody()->write(json_encode($data, JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json')
            ->withStatus($status);
    }
}
