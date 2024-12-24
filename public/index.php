<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$headers = getallheaders();
$authHeader = $headers['Authorization'] ?? '';

if (strpos($request, '/api') === 0) {
    require_once __DIR__ . '/../routes/api.php';
} else {
    require_once __DIR__ . '/../routes/web.php';
}
