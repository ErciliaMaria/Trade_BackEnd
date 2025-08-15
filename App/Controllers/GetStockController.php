<?php

namespace App\Controllers;

use App\Models\Stock;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class GetStockController
{
    public function execute(Request $request, Response $response): Response
    {
         $stocks = Stock::all();
        
        $response->getBody()->write($stocks->toJson());
        return $response->withHeader('Content-Type', 'application/json');
    }
}