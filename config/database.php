<?php

    return [
        'settings' => [
            'db' => [
                'driver'    => 'mysql',
                'host'      => 'localhost',
                'database'  => 'api_slim',
                'username'  => 'root',
                'password'  => '',
                'charset'   => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix'    => '',
                'options'   => [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => true,
                ],
            ],
        ],
    ];