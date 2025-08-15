<?php
use Illuminate\Database\Capsule\Manager as Capsule;

require __DIR__ . '/../vendor/autoload.php';

// Conexão com banco
$settings = require __DIR__ . '/../config/database.php';
$dbSettings = $settings['settings']['db'];

$capsule = new Capsule;
$capsule->addConnection($dbSettings);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$sql = file_get_contents(__DIR__ . '/create_tables.sql');

try {
    Capsule::connection()->getPdo()->exec($sql);
    echo "Tabelas criadas com sucesso!\n";
} catch (PDOException $e) {
    echo "Erro ao criar tabelas: " . $e->getMessage() . "\n";
}