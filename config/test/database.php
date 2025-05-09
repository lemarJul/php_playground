<?php

/**
 * Test database configuration
 */

return [
    'host' => $_ENV['DB_HOST'] ?? 'localhost',
    'dbname' => $_ENV['DB_NAME'] ?? 'php_training_test',
    'username' => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASS'],
    'persistent' => filter_var($_ENV['DB_PERSISTENT'] ?? false, FILTER_VALIDATE_BOOLEAN),
    'timezone' => $_ENV['DB_TIMEZONE'] ?? '+00:00'
];
