<?php

namespace App\Controllers;

use App\Request\LoginRequest;
use App\Models\User;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Firebase\JWT\JWT;

final class LoginController
{
    private string $jwtSecret = '';

    public function login(Request $request, Response $response): Response
    {
        $data = (array) $request->getParsedBody();

        $loginRequest = new LoginRequest();
        $errors = $loginRequest->validate($data);

        if (!empty($errors)) {
            $response->getBody()->write(json_encode(["errors" => $errors]));
            return $response->withStatus(400)->withHeader("Content-Type", "application/json");
        }

        $user = User::where('email', $data['email'] ?? null)->first();

        if (!$user || !password_verify($data['password'] ?? '', $user->password)) {
            $response->getBody()->write(json_encode(["error" => "Credenciais inválidas."]));
            return $response->withStatus(401)->withHeader("Content-Type", "application/json");
        }

        $payload = [
            'sub' => $user->id,
            'email' => $user->email,
            'iat' => time(),
            'exp' => time() + 3600 
        ];

        $jwt = JWT::encode($payload, $this->jwtSecret, 'HS256');

        $response->getBody()->write(json_encode([
            'message' => 'Login realizado com sucesso.',
            'token' => $jwt
        ]));

        return $response->withHeader("Content-Type", "application/json");
    }
}
