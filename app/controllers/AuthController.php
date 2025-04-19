<?php

namespace App\Controllers;

use League\Plates\Engine;
use PDO;

class AuthController {
    protected $db;
    protected $view;

    public function __construct() {
        // Kết nối database
        $this->db = new PDO('mysql:host=localhost;dbname=music_library;charset=utf8', 'root', '');

        // Khởi tạo view
        $this->view = new Engine(__DIR__ . '/../views/auth');
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['password_confirmation'] ?? '';

            // Kiểm tra đơn giản
            if ($password !== $confirm) {
                return;
            }

            // Kiểm tra tên đăng nhập đã tồn tại
            $stmt = $this->db->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->execute([$username]);
            if ($stmt->fetch()) {
                return;
            }

            // Mã hoá mật khẩu
            $hashed = password_hash($password, PASSWORD_DEFAULT);

            // Thêm user vào database
            $stmt = $this->db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $hashed]);

            return;
        }

        echo $this->view->render('register');
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            // Tìm user theo username
            $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user || !password_verify($password, $user['password'])) {
                return;
            }

            // Lưu user vào session
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'avatar' => $user['avatar'] ?? null,
                'role' => $user['role'] ?? 'user'
            ];

            return;
        }

        echo $this->view->render('login');
    }

    public function logout() {
        session_destroy();
        header("Location: /");
        exit;
    }
}
