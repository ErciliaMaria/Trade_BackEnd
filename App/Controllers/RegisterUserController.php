<?php

namespace App\Controllers;

use App\DAO\UsersDAO;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class RegisterUserController
{
    public function register(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;
        $balance = $data['balance'] ?? 0;

        if (!$email || !$password) {
            return $this->json($response, [
                'error' => 'Email e senha são obrigatórios.'
            ], 400);
        }

        $dao = new UsersDAO();

        if ($dao->getUserByEmail($email)) {
            return $this->json($response, [
                'error' => 'E-mail já cadastrado.'
            ], 409);
        }

        $usuario = $dao->createUser([
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'balance' => $balance
        ]);

        return $this->json($response, [
            'message' => 'Usuário cadastrado com sucesso!',
            'usuario' => $usuario
        ], 201);
    }
     private function json(Response $response, array $data, int $status = 200): Response
    {
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
    }
}
