<?php

declare(strict_types=1);

use Dotenv\Dotenv;
use Monolog\Logger;
use Monolog\Level;
use App\Core\Application;
use App\Core\Router\Router;
use Config\HttpRouteDefinitions;
use Monolog\Handler\StreamHandler;
use App\Controllers\ControllerFactory;
use App\Core\Controller\ControllerProvider;
use App\Core\Database\DatabaseConfigLoader;
use App\Core\RuntimeEnvironment;

// Load Composer's autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv::createImmutable(paths: __DIR__ . '/..');
$dotenv->load();
// Validate required variables based on environment
$dotenv->required('APP_ENV');
$dotenv->required('APP_NAME');
$dotenv->required('APP_VERSION');

if (RuntimeEnvironment::isProd()) {
    $dotenv->required([
        'DB_HOST',
        'DB_NAME',
        'DB_USER',
        'DB_PASS',
        'DB_PORT'
    ]);
} elseif (RuntimeEnvironment::isTest()) {
    $dotenv->required([
        'DB_HOST',
        'DB_TEST_NAME', // Separate test DB name
        'DB_USER',
        'DB_PASS'
    ]);
}

// DatabaseConfigLoader::forEnvironment()->getConnection();

// Error handling in development
if (RuntimeEnvironment::isDev()) {
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

// Application Initialization
$app = new Application(
    router: HttpRouteDefinitions::register(new Router()),
    logger: new Logger(
        name: App\Core\Helper\StringHelper::toSnakeCase($_ENV['APP_NAME'] ?? 'app_Name'),
        handlers: [
            new StreamHandler(
                stream: __DIR__ . '/../logs/app.log',
                level: RuntimeEnvironment::isProd() ? Level::Error : Level::Debug
            ),
        ]
    ),
    controllerProvider: (new ControllerProvider(new ControllerFactory())),
);

// Run the application
$app->run();
