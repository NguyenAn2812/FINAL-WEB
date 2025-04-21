<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Autoload
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use League\Plates\Engine;
use Bramus\Router\Router;
use App\Controllers\AuthController;
use App\Controllers\ComponentController;
use App\Controllers\SongController;
use App\Controllers\PlaylistController;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

define('BASE_URL', rtrim($_ENV['APP_URL'] ?? '/', '/'));

$view = new Engine(__DIR__ . '/../app/views');
$view->registerFunction('asset', fn($path) => BASE_URL . '/' . ltrim($path, '/'));
echo "<pre>";
print_r(get_declared_classes());
echo "</pre>";

die('🧪 Autoload test');
$router = new Router();
$auth = new AuthController();

// ROUTES

// main page
$router->get('/', fn() => print $view->render('layouts/main'));

// Component
$router->get('/component/(\w+)', fn($name) => (new ComponentController())->load($name));

// Songs controller
$router->post('/song/upload', fn() => (new SongController())->upload());

// API Playlist
$router->get('/playlist/json', fn() => (new PlaylistController())->getAllSongsAsJson());

// Auth
$router->post('/register', fn() => $auth->register());
$router->post('/login', fn() => $auth->login());
$router->get('/logout', fn() => $auth->logout());

// 404 fallback
$router->set404(fn() => http_response_code(404) && print "Page not found.");

// Run
$router->run();
