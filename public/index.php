<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';

use League\Plates\Engine;
use Bramus\Router\Router;
use App\Controllers\ComponentController;
use App\Controllers\AuthController;
$_ENV['APP_URL'] = $_ENV['APP_URL'] ?? '/FINAL-WEB/public';
define('BASE_URL', $_ENV['APP_URL']);
$auth = new AuthController();
$router = new Router();

$view = new Engine(__DIR__ . '/../app/views');
$view->registerFunction('asset', function ($path) {
    return '/FINAL-WEB/public' . $path;
});

// ✅ Route component: /component/login, /component/register,...
$router->get('/component/(\w+)', function ($name) {
    $controller = new ComponentController();
    $controller->load($name);
});

// ✅ Route trang chính: / → gọi layout chính
$router->get('/', function () use ($view) {
    echo $view->render('layouts/main');
});

// ✅ Route fallback 404
$router->set404(function () {
    http_response_code(404);
    echo "Page not found.";
});


$router->post('/register', function () use ($auth) {
    $auth->register();
});

$router->post('/login', function () use ($auth) {
    $auth->login();
});

$router->get('/logout', function () use ($auth) {
    $auth->logout();
});

$router->run();
