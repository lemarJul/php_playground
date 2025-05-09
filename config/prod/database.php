<?php

/**
 * Production database configuration*/

return [
    'host' => $_ENV['DB_HOST'] ?? 'db.production.example.com',
    'dbname' => $_ENV['DB_NAME'] ?? 'php_training_prod',
    'username' => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASS'],
    'persistent' => filter_var($_ENV['DB_PERSISTENT'] ?? true, FILTER_VALIDATE_BOOLEAN),
    'timezone' => $_ENV['DB_TIMEZONE'] ?? '+00:00'
];
