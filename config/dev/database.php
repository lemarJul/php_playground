<?php

/**
 * Development database configuration
 */

return [
    'unix_socket' => $_ENV['DB_UNIX_SOCKET'] ?? '/tmp/mysql.sock', // Common local socket paths
    'host' => $_ENV['DB_HOST'] ?? '127.0.0.1', // Prefer IP over 'localhost'
    'port' => $_ENV['DB_PORT'] ?? '3306',
    'dbname' => $_ENV['DB_NAME'] ?? 'dev_database',
    'username' => $_ENV['DB_USER'] ?? 'root',
    'password' => $_ENV['DB_PASS'] ?? '',
    'charset' => 'utf8mb4',
    'persistent' => filter_var($_ENV['DB_PERSISTENT'] ?? false, FILTER_VALIDATE_BOOLEAN),
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => true, // Better for debugging
        PDO::ATTR_STRINGIFY_FETCHES => false,
    ],
    'timezone' => $_ENV['DB_TIMEZONE'] ?? '+00:00'
];
