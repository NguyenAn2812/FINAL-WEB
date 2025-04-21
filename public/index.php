<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;
use League\Plates\Engine;
use Bramus\Router\Router;
use App\Controllers\ComponentController;
use App\Controllers\AuthController;
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$_ENV['APP_URL'] = $_ENV['APP_URL'] ?? '/FINAL-WEB/public';
define('BASE_URL', $_ENV['APP_URL']);


$view = new Engine(__DIR__ . '/../app/views');
$view->registerFunction('asset', function ($path) {
    return '/FINAL-WEB/public' . $path;
});

$auth = new AuthController();
$router = new Router();

$router->post('/song/upload', function () {
    $controller = new App\Controllers\SongController();
    $controller->upload();
});
$router->get('/component/(\w+)', function ($name) {
    $controller = new ComponentController();
    $controller->load($name);
});

$router->get('/', function () use ($view) {
    echo $view->render('layouts/main');
});

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