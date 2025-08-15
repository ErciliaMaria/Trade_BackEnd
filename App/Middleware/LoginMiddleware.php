<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Slim\Psr7\Response as SlimResponse;

class LoginMiddleware
{
    private string $jwtSecret = ""; 

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $authHeader = $request->getHeaderLine('Authorization');

        if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $response = new SlimResponse(401);
            $response->getBody()->write(json_encode(['error' => 'Token ausente ou inválido.']));
            return $response->withHeader('Content-Type', 'application/json');
        }

        $token = $matches[1];

        try {
            $decoded = JWT::decode($token, new Key($this->jwtSecret, 'HS256'));
           
            $request = $request->withAttribute('user', $decoded);
        } catch (\Exception $e) {
            $response = new SlimResponse(401);
            $response->getBody()->write(json_encode(['error' => 'Token inválido.']));
            return $response->withHeader('Content-Type', 'application/json');
        }

        return $handler->handle($request);
    }
}
