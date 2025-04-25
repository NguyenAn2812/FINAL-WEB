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
use App\Controllers\AdminController;

// Load biến môi trường
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// BASE_URL
define('BASE_URL', rtrim($_ENV['APP_URL'] ?? '/', '/'));

// View engine
$view = new Engine(__DIR__ . '/../app/views');
$view->registerFunction('asset', fn($path) => BASE_URL . '/' . ltrim($path, '/'));

// Router riêng cho admin
$router = new Router();
$auth = new AuthController();

// Admin routes
$router->mount('/admin', function () use ($router, $auth, $view) {

    // Trang login
    $router->match('GET|POST', '/login', function () use ($auth, $view) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            ob_start();
            $auth->login();
            $response = json_decode(ob_get_clean(), true);

            if ($response && $response['success'] && ($_SESSION['user']['role'] ?? '') === 'admin') {
                header('Location: ' . BASE_URL . '/admin/dashboard');
                exit;
            } else {
                echo $view->render('layouts/main', [
                    'content' => $auth->login(),
                    'error' => $response['message'] ?? null
                ]);
            }
        } else {
            echo $view->render('layouts/main', [
                'content' => $auth->login()
            ]);
        }
    });

    // Trang dashboard
    $router->get('/dashboard', function () use ($view) {
        if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
            header('Location: ' . BASE_URL . '/admin/login');
            exit;
        }
        $admin = new AdminController();
        ob_start();
        $admin->index();
        $adminContent = ob_get_clean();

        echo $view->render('layouts/admin_main', [
            'content' => $adminContent
        ]);
    });

    // Đăng xuất
    $router->get('/logout', function () {
        session_destroy();
        header('Location: ' . BASE_URL . '/admin/login');
        exit;
    });

});

// 404 fallback cho admin
$router->set404(fn() => http_response_code(404) && print "Admin page not found.");

// Chạy router
$router->run();
