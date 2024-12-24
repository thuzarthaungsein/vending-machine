<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/vendor/autoload.php';

session_start();

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$headers = getallheaders();
$authHeader = $headers['Authorization'] ?? '';

$webRoutes = require_once __DIR__ . '/routes/web.php';
$apiRoutes = require_once __DIR__ . '/routes/api.php';

$allRoutes = array_merge($webRoutes, $apiRoutes);

foreach ($allRoutes ?? [] as $route) {
    $routePath = preg_replace('#\{[a-zA-Z_]+\}#', '([a-zA-Z0-9_-]+)', $route['path']);
    $routeRegex = '#^' . $routePath . '$#';

    if ($method === $route['method'] && preg_match($routeRegex, $request, $matches)) {
        array_shift($matches); // Remove the full match from the array

        if ($route['isAuthRequired'] && !$route['isAuthenticated']) {
            header('Location: ' . $route['redirect']);
            exit;
        }

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

// If no route matched
http_response_code(404);
echo 'Page not found';
