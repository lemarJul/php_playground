<?php

namespace App\Core;

class ErrorHandler
{
    public static function handleGlobalException(\Throwable $e): never
    {
        // Log the exception
        error_log($e->getMessage());

        // Display appropriate error page based on environment
        if ($_ENV['APP_ENV'] === 'development') {
            echo '<h1>Error</h1>';
            echo '<p>' . $e->getMessage() . '</p>';
            echo '<pre>' . $e->getTraceAsString() . '</pre>';
        } else {
            // In production, show a generic error page
            header('HTTP/1.1 500 Internal Server Error');
            include __DIR__ . '/../Views/errors/500.php';
        }

        exit;
    }
}
