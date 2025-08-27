<?php

namespace App\Controllers;

use App\Request\TradeRequest;
use App\Repository\TradeRepository;
use App\Service\TradeService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class TradeController
{
    private TradeService $tradeService;

    public function __construct()
    {
        $repository = new TradeRepository();
        $this->tradeService = new TradeService($repository);
    }

    public function execute(Request $request, Response $response): Response
    {
        $data = (array) $request->getParsedBody();
        try {
            $trade = $this->tradeService->performTrade($data);
            return $this->jsonResponse($response, [
                'message' => 'Trade executado com sucesso',
                'trade' => $trade
            ]);
        } catch (\Exception $e) {
            $payload = ["errors" => [$e->getMessage()]];
            $response->getBody()->write(json_encode($payload));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(422);
        }
    }

    protected function jsonResponse(Response $response, array $data, int $status = 200): Response
    {
        $response->getBody()->write(json_encode($data));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }
}
