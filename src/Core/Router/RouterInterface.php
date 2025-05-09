<?php

namespace App\Core\Router;

use App\Core\Http\RequestInterface;

/**
 * Interface defining the contract for a router.
 */
interface RouterInterface
{
    /**
     * Registers a GET route.
     *
     * @param string $path The path for the route.
     * @param array $handler The handler for the route.
     * @return void
     */
    public function get(string $path, array $handler): void;

    /**
     * Registers a POST route.
     *
     * @param string $path The path for the route.
     * @param array $handler The handler for the route.
     * @return void
     */
    public function post(string $path, array $handler): void;

    /**
     * Registers a PUT route.
     *
     * @param string $path The path for the route.
     * @param array $handler The handler for the route.
     * @return void
     */
    public function put(string $path, array $handler): void;

    /**
     * Registers a DELETE route.
     *
     * @param string $path The path for the route.
     * @param array $handler The handler for the route.
     * @return void
     */
    public function delete(string $path, array $handler): void;

    /**
     * Resolves the current route based on the request.
     *
     * @param \App\Core\Http\RequestInterface $request The HTTP request object
     * @return array The resolved route information.
     */
    public function resolve(RequestInterface $request): array;

    /**
     * Retrieves all registered routes.
     *
     * @return array The list of registered routes.
     */
    public function getRoutes(): array;
}
