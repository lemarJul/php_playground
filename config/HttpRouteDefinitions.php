<?php

declare(strict_types=1);

namespace Config;

use App\Core\Router\RouterInterface;

class HttpRouteDefinitions
{
    /**
     * Define all application routes
     *
     * @param \App\Core\Router\RouterInterface $router
     * @return \App\Core\Router\RouterInterface
     */
    public static function register(RouterInterface $router): RouterInterface
    {
        /**
         * Documentation for adding routes
         *
         * Routes are defined using the register() method of the HttpRouteDefinitions class.
         * This method takes an instance of RouterInterface as an argument and returns it after
         * defining the routes.
         *
         * Example:
         *
         * $router->get('/example', [ExampleController::class, 'exampleMethod']);
         * $router->post('/example', [ExampleController::class, 'exampleSubmitMethod']);
         *
         * For routes with parameters, use curly braces to define the parameter:
         *
         * $router->get('/example/{id}', [ExampleController::class, 'exampleShowMethod']);
         *
         * To define a route with a specific HTTP method, use the corresponding method on the router:
         *
         * $router->put('/example/{id}', [ExampleController::class, 'exampleUpdateMethod']);
         *
         */

        return $router;
    }
}
