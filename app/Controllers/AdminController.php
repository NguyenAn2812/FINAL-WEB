<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Song;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (!$this->isAdmin()) {
            $this->view('auth/login', ['admin_mode' => true]);
            return;
        }
        $this->view('admin/dashboard');
    }

    public function login()
    {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($username === 'admin' && $password === 'yourpassword') {
            $_SESSION['admin_logged_in'] = true;
            header('Location: ' . BASE_URL . '/admin');
            exit;
        }

        $_SESSION['error'] = 'Incorrect admin credentials!';
        header('Location: ' . BASE_URL . '/admin');
    }

    public function logout()
    {
        unset($_SESSION['admin_logged_in']);
        header('Location: ' . BASE_URL . '/admin');
    }

    private function isAdmin()
    {
        return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
    }

    public function listUsers()
    {
        if (!$this->isAdmin()) {
            header('Location: ' . BASE_URL . '/admin/login');
            exit;
        }
        $users = User::all();
        $this->view('admin/users', ['users' => $users]);
    }

    public function listSongs()
    {
        if (!$this->isAdmin()) {
            header('Location: ' . BASE_URL . '/admin/login');
            exit;
        }
        $songs = Song::all();
        $this->view('admin/songs', ['songs' => $songs]);
    }
}
