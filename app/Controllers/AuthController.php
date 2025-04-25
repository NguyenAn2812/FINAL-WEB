<?php

namespace App\Controllers;

use League\Plates\Engine;
use App\Controllers\UserController;

class AuthController
{
    protected $view;
    protected $userController;

    public function __construct()
    {
        $this->view = new Engine(__DIR__ . '/../views/auth');
        $this->userController = new UserController();
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['password_confirmation'] ?? '';

            if ($password !== $confirm) {
                echo json_encode(['success' => false, 'message' => 'Passwords do not match']);
                return;
            }

            if ($this->userController->findByUsername($username)) {
                echo json_encode(['success' => false, 'message' => 'Username already exists']);
                return;
            }

            $this->userController->createUser($username, $email, $password);
            echo json_encode(['success' => true]);
            return;
        }

        echo $this->view->render('register');
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->userController->findByUsername($username);

            if (!$user || !$this->userController->verifyPassword($password, $user['password'])) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Wrong account or password'
                ]);
                return;
            }

            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'avatar' => $user['avatar'] ?? null,
                'role' => $user['role'] ?? 'user'
            ];

            echo json_encode(['success' => true]);
            return;
        }
        return $this->view->render('login');
    }
    public function logout()
    {
        session_destroy();
        exit;
    }
}
