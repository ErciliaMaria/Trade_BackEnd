<?php

use Slim\Factory\AppFactory;
use Illuminate\Database\Capsule\Manager as Capsule;

require __DIR__ . '/../vendor/autoload.php';

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$settings = require __DIR__ . '/../config/database.php';
$dbSettings = $settings['settings']['db'];

$capsule = new Capsule;
$capsule->addConnection($dbSettings);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$app = AppFactory::create();

$app->addRoutingMiddleware();

$app->addBodyParsingMiddleware();

require __DIR__ . '/../routes/routes.php';

$app->run();
