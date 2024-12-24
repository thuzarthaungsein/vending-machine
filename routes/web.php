<?php

use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\PlaygroundController;
use App\Controllers\ProductsController;

return [
    [
        'method' => 'GET',
        'path' => '/',
        'isAuthRequired' => true,
        'isAuthenticated' => isset($_SESSION['user']),
        'handler' => [AuthController::class, 'dashboard'],
        'redirect' => '/login'
    ],
    [
        'method' => 'GET',
        'path' => '/playground',
        'isAuthRequired' => false,
        'isAuthenticated' => isset($_SESSION['user']),
        'handler' => [PlaygroundController::class, 'index'],
        'redirect' => '/login'
    ],
    [
        'method' => 'GET',
        'path' => '/products/create',
        'isAuthRequired' => true,
        'isAuthenticated' => isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin',
        'handler' => [ProductsController::class, 'create'],
        'redirect' => '/login' // unauthorized
    ],
    [
        'method' => 'GET',
        'path' => '/shop',
        'isAuthRequired' => false,
        'handler' => [ProductsController::class, 'shop'],
    ],
    [
        'method' => 'GET',
        'path' => '/login',
        'isAuthRequired' => false,
        'handler' => [AuthController::class, 'showLoginForm'],
    ],
    [
        'method' => 'GET',
        'path' => '/logout',
        'isAuthRequired' => false,
        'handler' => [AuthController::class, 'logout'],
    ],
    [
        'method' => 'GET',
        'path' => '/register',
        'isAuthRequired' => false,
        'handler' => [AuthController::class, 'showRegisterForm'],
    ],
    [
        'method' => 'GET',
        'path' => '/admin/dashboard',
        'isAuthRequired' => true,
        'isAuthenticated' => isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin',
        'handler' => [AdminController::class, 'dashboard'],
        'redirect' => '/login' // unauthorized
    ],

    [
        'method' => 'GET',
        'path' => '/products',
        'isAuthRequired' => true,
        'isAuthenticated' => isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin',
        'handler' => [ProductsController::class, 'list'],
        'redirect' => '/login' // unauthorized
    ],
    [
        'method' => 'GET',
        'path' => '/products/{id}',
        'isAuthRequired' => false,
        'handler' => [ProductsController::class, 'show'],
    ],
    [
        'method' => 'GET',
        'path' => '/products/{id}/edit',
        'isAuthRequired' => true,
        'isAuthenticated' => isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin',
        'handler' => [ProductsController::class, 'edit'],
        'redirect' => '/login' // unauthorized
    ],


    [
        'method' => 'POST',
        'path' => '/login',
        'isAuthRequired' => false,
        'handler' => [AuthController::class, 'login'],
    ],
    [
        'method' => 'POST',
        'path' => '/register',
        'isAuthRequired' => false,
        'handler' => [AuthController::class, 'register'],
    ],
    [
        'method' => 'POST',
        'path' => '/products/store',
        'isAuthRequired' => true,
        'isAuthenticated' => isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin',
        'handler' => [ProductsController::class, 'store'],
        'redirect' => '/login' // unauthorized
    ],
    [
        'method' => 'POST',
        'path' => '/products/purchase',
        'isAuthRequired' => true,
        'isAuthenticated' => isset($_SESSION['user']),
        'handler' => [ProductsController::class, 'purchase'],
        'redirect' => '/login' // unauthorized
    ],
    [
        // 'method' => 'PUT', // html form can't handle PUT method will override with POST
        'method' => 'POST',
        'path' => '/products/{id}/update',
        'isAuthRequired' => true,
        'isAuthenticated' => isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin',
        'handler' => [ProductsController::class, 'update'],
    ],
    [
        // 'method' => 'DELETE', // html form can't handle DELETE method will override with POST
        'method' => 'POST',
        'path' => '/products/{id}/delete',
        'isAuthRequired' => true,
        'isAuthenticated' => isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin',
        'handler' => [ProductsController::class, 'destroy'],
    ],
];
