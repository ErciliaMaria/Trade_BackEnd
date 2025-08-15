<?php

use App\Controllers\GetStockController;
use App\Controllers\LoginController;
use App\Controllers\RegisterUserController;
use App\Controllers\TradeController;
use App\Controllers\TransactionsController;
use App\Middleware\LoginMiddleware;
use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();
$app->addBodyParsingMiddleware();

$app->group('/auth', function ($group) {
    $group->post('/login', [LoginController::class, 'login']);
    $group->post('/register', [RegisterUserController::class, 'register']);
});

$app->group('/transactions', function ($group) {
    $group->post('/', [TransactionsController::class, 'create']);
    $group->get('/user/{id}', [TransactionsController::class, 'listByUser']);
})->add(LoginMiddleware::class);

$app->post('/trade', [TradeController::class, 'execute']);
$app->get('/getStock', [GetStockController::class, 'execute']);

$app->get('/{name}', function (Response $response, $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    return $response;
});
