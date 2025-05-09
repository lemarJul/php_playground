<?php

declare(strict_types=1);

use Monolog\Logger;
use Monolog\Level;
use Monolog\Handler\StreamHandler;

// Load Composer's autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(paths: __DIR__ . '/..');
$dotenv->load();

// Error handling in development
if ($_ENV['APP_ENV'] === 'development') {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
    ini_set('display_startup_errors', '0');
    error_reporting(0);
}

// Add a global exception handler with
set_exception_handler(function (Throwable $exception) {
    if (class_exists('App\Core\Throwable\ErrorHandler')) {
        App\Core\Throwable\ErrorHandler::handleGlobalException($exception);
    } else {
        // Fallback if ErrorHandler isn't available
        error_log($exception->getMessage());
        echo 'An unexpected error occurred.';
        exit(1);
    };
});

// Configure the logger
$logger = new Logger('app');
$logger->pushHandler(new StreamHandler(
    __DIR__ . '/../logs/app.log',
    $_ENV['APP_ENV'] === 'production' ? Level::Error : Level::Debug
));
