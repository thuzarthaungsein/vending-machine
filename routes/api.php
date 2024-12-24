<?php

use App\Controllers\Api\V1\ProductController;
use App\Middleware\JWTAuth;

$routes = [
    [
        'method' => 'GET',
        'path' => '/api/products',
        'middleware' => [JWTAuth::class],
        'handler' => [ProductController::class, 'list'],
    ],
    [
        'method' => 'POST',
        'path' => '/api/products',
        'middleware' => [JWTAuth::class],
        'handler' => [ProductController::class, 'create'],
    ],
];

// Dispatch API routes
foreach ($routes as $route) {
    $routePath = preg_replace('#\{[a-zA-Z_]+\}#', '([a-zA-Z0-9_-]+)', $route['path']);
    $routeRegex = '#^' . $routePath . '$#';

    if ($method === $route['method'] && preg_match($routeRegex, $request, $matches)) {
        if (isset($route['middleware'])) {
            [$middlewareClass, $middlewareMethod] = $route['middleware'];
            $middleware = new $middlewareClass();
            if (!$middleware->handle()) {
                http_response_code(401);
                echo 'Unauthorized';
                exit;
            }
        }

        array_shift($matches); // Remove the full match from the array

        [$controllerClass, $method] = $route['handler'];
        if (class_exists($controllerClass) && method_exists($controllerClass, $method)) {
            $controller = new $controllerClass();
            $controller->$method(...$matches); // Pass params
            exit;
        } else {
            http_response_code(500);
            echo 'Handler not found';
            exit;
        }
    }
}

// Default: route not found
http_response_code(404);
echo 'Page not found';
