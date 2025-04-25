<?php
session_start();
require_once '../core/App.php';
require_once '../core/Database.php';
require_once '../config.php';
require_once '../app/controllers/AuthController.php';
require_once '../app/controllers/AdminController.php';

use App\Controllers\AuthController;
use App\Controllers\AdminController;

// Nếu chưa đăng nhập hoặc không phải admin → hiển thị form login
if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    $auth = new AuthController();

    // Nếu gửi form thì xử lý login POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        ob_start();
        $auth->login();
        $response = json_decode(ob_get_clean(), true);

        if ($response && $response['success'] && ($_SESSION['user']['role'] ?? '') === 'admin') {
            // Đăng nhập thành công là admin → load dashboard
            (new AdminController())->index();
        } else {
            // Hiện lại form login với thông báo lỗi nếu có
            echo "<div class='text-red-500 text-center p-2'>" . htmlspecialchars($response['message'] ?? '') . "</div>";
            echo $auth->login(); // render lại form login
        }
    } else {
        // GET request → hiển thị form login
        echo $auth->login(); // render login view
    }
    return;
}

(new AdminController())->index();
