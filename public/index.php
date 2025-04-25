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

$router = new Router();
$auth = new AuthController();

// ROUTES
$router->get('/profile', fn() => (new \App\Controllers\UserController())->showProfile());
$router->post('/user/update-profile', fn() => (new \App\Controllers\UserController())->updateProfile());

// main page
$router->get('/', fn() => print $view->render('layouts/main'));

// Component
$router->get('/component/(\w+)', fn($name) => (new ComponentController())->load($name));

// Songs controller
$router->post('/song/upload', fn() => (new SongController())->upload());

// API Playlist
$router->get('/playlist/list', fn() => (new PlaylistController())->listContainer());
$router->get('/playlist/view/(\d+)', fn($id) => (new PlaylistController())->display($id));
$router->get('/playlist/addform', fn() => (new PlaylistController())->showAddSongToPlaylistForm($_GET['song_id']));
$router->post('/playlist/add', fn() => (new PlaylistController())->addSongToPlaylist());
$router->post('/playlist/create', fn() => (new \App\Controllers\PlaylistController())->create());
$router->get('/playlist/json', fn() => (new \App\Controllers\PlaylistController())->getSongsByPlaylistId());
$router->get('/playlist/random', function () {
    $limit = $_GET['limit'] ?? 10;
    $songModel = new \App\Models\Song();
    $songs = $songModel->getRandomSongs((int) $limit);
    header('Content-Type: application/json');
    echo json_encode($songs);
});

if (isset($_GET['url']) && $_GET['url'] === 'admin') {
    require_once '../app/controllers/AdminController.php';
    $controller = new App\Controllers\AdminController();
    $controller->index();
    exit;
}

// Auth
$router->post('/register', fn() => $auth->register());
$router->post('/login', fn() => $auth->login());
$router->get('/logout', fn() => $auth->logout());

// 404 fallback
$router->set404(fn() => http_response_code(404) && print "Page not found.");

// Run
$router->run();
?>
