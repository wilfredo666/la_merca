<?php

declare(strict_types=1);

// Rutas base del proyecto
const BASE_PATH = __DIR__;
const APP_PATH = BASE_PATH . '/app';
const VIEW_PATH = APP_PATH . '/views';

require_once APP_PATH . '/controllers/Controller.php';
require_once APP_PATH . '/controllers/HomeController.php';
require_once APP_PATH . '/controllers/CartController.php';
require_once APP_PATH . '/models/Product.php';
require_once APP_PATH . '/models/Category.php';

session_start();

$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
$path = parse_url($requestUri, PHP_URL_PATH);
$path = str_replace('\\', '/', $path);
$scriptName = str_replace('\\', '/', $scriptName);
$baseDir = rtrim(str_replace('\\', '/', dirname($scriptName)), '/');

$routeParam = $_GET['route'] ?? null;
if (is_string($routeParam) && $routeParam !== '') {
    $route = trim($routeParam, '/');
    $segments = $route === '' ? [] : explode('/', $route);
} else {
    if ($baseDir !== '' && strpos($path, $baseDir) === 0) {
        $path = substr($path, strlen($baseDir));
    }

    $path = trim($path, '/');
    $segments = $path === '' ? [] : explode('/', $path);
}

$controllerName = $segments[0] ?? 'home';
$action = $segments[1] ?? 'index';

if ($controllerName === 'cart' && $action === 'checkout') {
    $controllerName = 'cart';
    $action = 'checkout';
}

if ($controllerName === 'cart' && $action === 'confirm') {
    $controllerName = 'cart';
    $action = 'confirm';
}

$controllerClass = ucfirst($controllerName) . 'Controller';
$action = preg_replace('/[^a-zA-Z0-9_]/', '', $action);

$availableControllers = [
    'HomeController',
    'CartController',
];

if (!in_array($controllerClass, $availableControllers, true)) {
    http_response_code(404);
    echo 'Página no encontrada';
    exit;
}

$controller = new $controllerClass();

if (!method_exists($controller, $action)) {
    http_response_code(404);
    echo 'Página no encontrada';
    exit;
}

echo $controller->{$action}();
