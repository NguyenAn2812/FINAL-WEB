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
                echo "<p class='text-red-500'>Passwords do not match</p>";
                return;
            }

            if ($this->userController->findByUsername($username)) {
                echo "<p class='text-red-500'>Username already exists</p>";
                return;
            }

            $this->userController->createUser($username, $email, $password);
            header("Location: " . BASE_URL);
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
                echo "<p class='text-red-500'>Wrong account or password</p>";
                return;
            }

            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'avatar' => $user['avatar'] ?? null,
                'role' => $user['role'] ?? 'user'
            ];

            header("Location: " . BASE_URL);
            return;
        }

        echo $this->view->render('login');
    }

    public function logout()
    {
        session_destroy();
        header("Location: " . BASE_URL);
        exit;
    }
}
