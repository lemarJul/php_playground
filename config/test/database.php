<?php

/**
 * Test database configuration
 */

return [
    'unix_socket' => $_ENV['DB_TEST_UNIX_SOCKET'],
    'port' => $_ENV['DB_TEST_PORT'] ?? '3306',
    'dbname' => $_ENV['DB_TEST_NAME'],
    'username' => $_ENV['DB_TEST_USER'],
    'password' => $_ENV['DB_TEST_PASS'],
    'charset' => 'utf8mb4',
    'persistent' => false, // Force new connections for test isolation
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false, // Match production
        PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
    ],
    // Test-specific settings
    'test_options' => [
        'cleanup' => $_ENV['DB_TEST_CLEANUP'] ?? 'transaction', // transaction|truncate|drop
        'fixtures' => $_ENV['DB_TEST_FIXTURES_PATH'] ?? null
    ]
];
