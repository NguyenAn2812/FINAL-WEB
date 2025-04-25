<?php
session_start();
require_once '../core/App.php';
require_once '../core/Database.php';
require_once '../config.php';
require_once '../app/controllers/AuthController.php';
require_once '../app/controllers/AdminController.php';

use App\Controllers\AuthController;
use App\Controllers\AdminController;

if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    $auth = new AuthController();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        ob_start();
        $auth->login();
        $response = json_decode(ob_get_clean(), true);

        if ($response && $response['success'] && ($_SESSION['user']['role'] ?? '') === 'admin') {
            (new AdminController())->index();
        } else {
            echo "<div class='text-red-500 text-center p-2'>" . htmlspecialchars($response['message'] ?? '') . "</div>";
            echo $auth->login();
        }
    } else {
        echo $auth->login();
    }
    return;
}

(new AdminController())->index();
