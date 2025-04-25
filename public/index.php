<?php
session_start();

// Hiển thị lỗi debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Autoload composer
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use League\Plates\Engine;
use Bramus\Router\Router;
use App\Controllers\AuthController;
use App\Controllers\ComponentController;
use App\Controllers\SongController;
use App\Controllers\PlaylistController;
use App\Controllers\UserController;
use App\Controllers\AdminController;

// Load biến môi trường
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// BASE_URL
define('BASE_URL', rtrim($_ENV['APP_URL'] ?? '/', '/'));

// View engine
$view = new Engine(__DIR__ . '/../app/views');
$view->registerFunction('asset', fn($path) => BASE_URL . '/' . ltrim($path, '/'));

// Khởi tạo router
$router = new Router();
$auth = new AuthController();

// ======================= ROUTES ==========================

// Auth
$router->post('/register', fn() => $auth->register());
$router->post('/login', fn() => $auth->login());
$router->get('/logout', fn() => $auth->logout());

// Profile
$router->get('/profile', fn() => (new UserController())->showProfile());
$router->post('/user/update-profile', fn() => (new UserController())->updateProfile());

// Trang chính
$router->get('/', fn() => print $view->render('layouts/main'));

// Component
$router->get('/component/(\w+)', fn($name) => (new ComponentController())->load($name));

// Song controller
$router->post('/song/upload', fn() => (new SongController())->upload());

// Playlist controller
$router->get('/playlist/list', fn() => (new PlaylistController())->listContainer());
$router->get('/playlist/view/(\d+)', fn($id) => (new PlaylistController())->display($id));
$router->get('/playlist/addform', fn() => (new PlaylistController())->showAddSongToPlaylistForm($_GET['song_id']));
$router->post('/playlist/add', fn() => (new PlaylistController())->addSongToPlaylist());
$router->post('/playlist/create', fn() => (new PlaylistController())->create());
$router->get('/playlist/json', fn() => (new PlaylistController())->getSongsByPlaylistId());
$router->get('/playlist/random', function () {
    $limit = $_GET['limit'] ?? 10;
    $songModel = new \App\Models\Song();
    $songs = $songModel->getRandomSongs((int) $limit);
    header('Content-Type: application/json');
    echo json_encode($songs);
});

// ============ ADMIN ROUTES ==============

// Trang dashboard admin
$router->get('/admin', fn() => (new AdminController())->dashboard());

// Admin xử lý login
$router->post('/admin/login', fn() => (new AdminController())->login());

// Admin logout
$router->get('/admin/logout', fn() => (new AdminController())->logout());

// Admin quản lý users
$router->get('/admin/users', fn() => (new AdminController())->listUsers());

// Admin quản lý songs
$router->get('/admin/songs', fn() => (new AdminController())->listSongs());

// ========== 404 fallback ==========
$router->set404(fn() => http_response_code(404) && print "Page not found.");

// Run router
$router->run();
