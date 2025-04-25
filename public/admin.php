<?php
session_start();

// Debug bật lỗi
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Autoload composer
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use League\Plates\Engine;
use App\Controllers\AuthController;
use App\Controllers\AdminController;

// Load biến môi trường từ .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Define BASE_URL
define('BASE_URL', rtrim($_ENV['APP_URL'] ?? '/', '/'));

// Setup view Engine
$view = new Engine(__DIR__ . '/../app/views');
$view->registerFunction('asset', fn($path) => BASE_URL . '/' . ltrim($path, '/'));

// ========================
// Xử lý đăng nhập admin
// ========================

// Nếu chưa đăng nhập hoặc không phải admin
if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    $auth = new AuthController();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        ob_start();
        $auth->login();
        $response = json_decode(ob_get_clean(), true);

        if ($response && $response['success'] && ($_SESSION['user']['role'] ?? '') === 'admin') {
            (new AdminController())->index();
        } else {
            echo "<div class='text-danger text-center p-3'>".htmlspecialchars($response['message'] ?? 'Access denied')."</div>";
            echo $auth->login(); // render lại form login
        }
    } else {
        echo $auth->login(); // render form login
    }
    exit;
}

// Đã đăng nhập và đúng role admin
(new AdminController())->index();
