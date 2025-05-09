<?php

declare(strict_types=1);

namespace App\Core\Router;

use App\Core\HttpException;

class Router implements RouterInterface
{
    // Array to store routes
    private array $routes = [];

    // Constants for HTTP methods
    const GET = "GET";
    const POST = 'POST';
    const PUT = 'PUT';
    const DELETE = 'DELETE';

    /**
     * Add a route to the router
     *
     * @param string $method HTTP method (GET, POST, etc.)
     * @param string $path URL path
     * @param callable|array $handler The route handler
     * @return void
     */
    private function addRoute(string $method, string $path, callable|array $handler): void
    {
        $this->routes[strtoupper($method)][$path] = $handler;
    }

    // Add a GET route
    public function get(string $path, array $handler): void
    {
        $this->addRoute(self::GET, $path, $handler);
    }

    // Add a POST route
    public function post(string $path, array $handler): void
    {
        $this->addRoute(self::POST, $path, $handler);
    }

    // Add a PUT route
    public function put(string $path, array $handler): void
    {
        $this->addRoute(self::PUT, $path, $handler);
    }

    // Add a DELETE route
    public function delete(string $path, array $handler): void
    {
        $this->addRoute(self::DELETE, $path, $handler);
    }

    /**
     * Resolve the request by matching the current HTTP method and URI to a registered route.
     *
     * This method extracts the request method and URI from the server superglobal,
     * then attempts to find a matching route in the router's registered routes.
     * If a match is found, it returns the route handler and any extracted parameters.
     * If no match is found, it throws a 404 exception.
     *
     * @throws \Exception
     * @return array<array|mixed|null> An array containing the route handler and any extracted parameters.
     */
    public function resolve(): array
    {
        // Get the request method
        $method = $_SERVER['REQUEST_METHOD'];

        // Get the request URI
        $path = $_SERVER['REQUEST_URI'] ?? '/';

        // Remove query string from the path
        [$path] = explode('?', $path);

        // Find matching route
        foreach ($this->routes[$method] as $routePath => $callback) {
            // Convert route path to regex pattern
            $pattern = preg_replace('/\{([^\/]+)\}/', '(?P<$1>[^\/]+)', $routePath);
            $pattern = "@^" . $pattern . "$@D";

            // Check if the path matches the pattern
            if (preg_match($pattern, $path, $matches)) {
                // Filter named parameters
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                // Cast numeric parameters to integers
                foreach ($params as &$param) {
                    if (is_numeric($param)) {
                        $param = (int)$param;
                    }
                }

                // Return the callback and parameters
                return [$callback, $params];
            }
        }

        // Throw a 404 exception if no route matches
        throw HttpException::badRequest("Route not found for path: $path");
    }

    /**
     * Get all registered routes
     *
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }
}
