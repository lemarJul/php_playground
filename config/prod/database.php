<?php

/**
 * Production database configuration*/

return [
    'host' => $_ENV['DB\_HOST'], // Required - no fallback
    'port' => $_ENV['DB\_PORT'] ?? '3306', // Default MySQL port

    'dbname' => $_ENV['DB_NAME'],
    'username' => $_ENV['DB_USER'],
    'charset' => 'utf8mb4',
    'password' => $_ENV['DB_PASS'],
    'persistent' => filter_var($_ENV['DB_PERSISTENT'] ?? true, FILTER_VALIDATE_BOOLEAN),
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::MYSQL_ATTR_SSL_CA => $_ENV['DB_SSL_CA_PATH'] ?? null,
        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
    ],
    'timezone' => $_ENV['DB_TIMEZONE'] ?? '+00:00'
];
