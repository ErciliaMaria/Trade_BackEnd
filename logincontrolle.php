<?php

namespace App\Controllers;

use App\DAO\UsersDAO;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Firebase\JWT\JWT;

final class LoginController
{
    private string $jwtSecret = "sua_chave_secreta_aqui";

    public function login(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        var_dump($data);
        exit;
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;
        $balance = $data['balance'] ?? null;


        $usuarioDAO = new UsersDAO();
        $usuario = $usuarioDAO->getUserByEmail($email);

        if (!$email) {
            $response->getBody()->write(json_encode([
                'error' => 'Email í obrigatório.'
            ]));
        }

        if (!password_verify($password, $usuario->password)) {
            $response->getBody()->write(json_encode([
                'error' => 'Senha inválida.'
            ]));
        }

        $payload = [
            'sub' => $usuario->id,
            'email' => $usuario->email,
            'balance' => $balance,
            'iat' => time(),
            'exp' => time() + 3600
        ];

        $jwt = JWT::encode($payload, $this->jwtSecret, 'HS256');

        $response->getBody()->write(json_encode([
            'message' => 'Login realizado com sucesso.',
            'token' => $jwt
        ]));

        return $response->withHeader('Content-Type', 'application/json');
    }
}
