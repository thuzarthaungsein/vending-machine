<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/vendor/autoload.php';

use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\ProductsController;

session_start();

$request = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// to handle DELETE method
if ($method === 'POST' && isset($_POST['_method'])) {
    $method = strtoupper($_POST['_method']);
}

$authController = new AuthController();
$productController = new ProductsController();
$adminController = new AdminController();

if ($method == 'GET') {
    switch ($request) {
        case '/':
            if (isset($_SESSION['user'])) {
                $authController->dashboard();
            } else {
                header('Location: /login');
            }
            break;

        case '/login':
            $authController->showLoginForm();
            break;

        case '/logout':
            $authController->logout();
            break;

        case '/register':
            $authController->showRegisterForm();
            break;

        case '/shop':
            $productController->shop();
            break;

        case '/admin/dashboard':
            if ($_SESSION['user']['role'] === 'admin') {
                $adminController->dashboard();
            } else {
                header('Location: /unauthorized.php');
            }
            break;

        case '/products':
            if ($_SESSION['user']['role'] === 'admin') {
                $productController->list();
            } else {
                header('Location: /unauthorized.php');
            }
            break;

        case preg_match('/^\/products\/[0-9]+$/', $request) ? $request : null:
            $id = explode('/', $request)[2];
            $productController->show($id);
            break;

        case preg_match('/^\/products\/[0-9]+\/edit$/', $request) ? $request : null:
            $id = explode('/', $request)[2];
            $productController->edit($id);
            break;

        case '/products/create':
            if ($_SESSION['user']['role'] === 'admin') {
                $productController->create();
            } else {
                header('Location: /unauthorized.php');
            }
            break;

        default:
            http_response_code(404);
            echo "Page not found";
            break;
    }
} elseif ($method === 'POST') {
    switch ($request) {
        case '/login':
            $authController->login();
            break;

        case '/register':
            $authController->register();
            break;

        case '/products/store':
            if ($_SESSION['user']['role'] === 'admin') {
                $productController->store();
            } else {
                header('Location: /unauthorized.php');
            }
            break;

        case '/products/purchase':
            $productController->purchase();
            break;

        default:
            http_response_code(404);
            echo "Page not found";
            break;
    }
} elseif ($method === 'PUT' || $method === 'PATCH') {
    switch ($request) {
        case preg_match('/^\/products\/[0-9]+\/update$/', $request) ? $request : null:
            if ($_SESSION['user']['role'] === 'admin') {
                $id = explode('/', $request)[2];
                $productController->update($id);
            } else {
                header('Location: /unauthorized.php');
            }
            break;

        default:
            http_response_code(404);
            echo "Page not found";
            break;
    }
} elseif ($method === 'DELETE') {
    switch ($request) {
        case preg_match('/^\/products\/[0-9]+\/delete$/', $request) ? $request : null:
            if ($_SESSION['user']['role'] === 'admin') {
                $id = explode('/', $request)[2];
                $productController->destroy($id);
            } else {
                header('Location: /unauthorized.php');
            }
            break;

        default:
            http_response_code(404);
            echo "Page not found";
            break;
    }
} else {
    http_response_code(405);
    echo "HTTP method not supported";
}
