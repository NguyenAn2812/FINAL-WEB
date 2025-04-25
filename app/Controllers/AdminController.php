<?php

namespace App\Controllers;

use League\Plates\Engine;
use App\Models\User;
use App\Models\Song;

class AdminController
{
    protected $view;

    public function __construct()
    {
        $this->view = new Engine(__DIR__ . '/../views'); // Tạm dùng lại auth view để render popup login
    }

    private function isAdmin()
    {
        return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
    }

    public function dashboard()
    {
        if (!$this->isAdmin()) {
            echo $this->view->render('admin/admin', ['showLogin' => true]); // truyền biến để hiển thị popup
            return;
        }

        $userModel = new User();
        $songModel = new Song();
        $playlistModel = new \App\Models\Playlist();

        echo $this->view->render('admin/admin', [
            'users' => $userModel->all(),
            'songs' => $songModel->all(),
            'playlists' => $playlistModel->all(),
            'showLogin' => false
        ]);
    }


    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            if ($username === 'admin' && $password === 'yourpassword') {
                $_SESSION['admin_logged_in'] = true;
                echo json_encode(['success' => true]);
                return;
            }

            echo json_encode([
                'success' => false,
                'message' => 'Incorrect admin credentials'
            ]);
            return;
        }

        echo $this->view->render('admin/login', ['admin_mode' => true]);
    }

    public function logout()
    {
        unset($_SESSION['admin_logged_in']);
        header('Location: ' . BASE_URL . '/admin');
        exit;
    }

    public function listUsers()
    {
        if (!$this->isAdmin()) {
            header('Location: ' . BASE_URL . '/admin');
            exit;
        }

        $userModel = new User();
        $users = $userModel->all(); // Giả sử bạn đã có method all() trong User model

        $adminView = new Engine(__DIR__ . '/../views/admin');
        echo $adminView->render('users', ['users' => $users]);
    }

    public function listSongs()
    {
        if (!$this->isAdmin()) {
            header('Location: ' . BASE_URL . '/admin');
            exit;
        }

        $songModel = new Song();
        $songs = $songModel->all(); // Giả sử bạn đã có method all() trong Song model

        $adminView = new Engine(__DIR__ . '/../views/admin');
        echo $adminView->render('songs', ['songs' => $songs]);
    }
}
