<?php

namespace App\Controllers;

use League\Plates\Engine;
use App\Models\User;
use App\Models\Song;
use App\Models\Playlist;

class AdminController
{
    protected $view;

    public function __construct()
    {
        $this->view = new Engine(__DIR__ . '/../views/admin');
    }

    private function isAdmin()
    {
        return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
    }

    public function dashboard()
    {
        if (!$this->isAdmin()) {
            echo $this->view->render('login', ['admin_mode' => true]);
            return;
        }

        $userModel = new User();
        $songModel = new Song();

        $totalUsers = $userModel->countAll();
        $totalSongs = $songModel->countAll();
        $topArtist = $userModel->getTopUploader();

        echo $this->view->render('dashboard', [
            'totalUsers' => $totalUsers,
            'totalSongs' => $totalSongs,
            'topArtistSongCount' => $topArtist['count'] ?? 0,
        ]);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = (new User())->findByUsername($username);

            if ($user && ($user['role'] ?? '') === 'Admin' && password_verify($password, $user['password'])) {
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

        echo $this->view->render('login', ['admin_mode' => true]);
    }

    public function logout()
    {
        unset($_SESSION['admin_logged_in']);
        header('Location: ' . BASE_URL . '/admin');
        exit;
    }

    // ==== API JSON DATA ====
    public function getUsers()
    {
        $users = (new User())->all();
        header('Content-Type: application/json');
        echo json_encode($users);
    }

    public function getSongs()
    {
        $songs = (new Song())->all();
        header('Content-Type: application/json');
        echo json_encode($songs);
    }

    public function getPlaylists()
    {
        $playlists = (new Playlist())->all();
        header('Content-Type: application/json');
        echo json_encode($playlists);
    }

    // ==== ACTIONS ====

    public function deleteSong($id)
    {
        (new Song())->deleteById($id);
        echo json_encode(['success' => true]);
    }

    public function deletePlaylist($id)
    {
        (new Playlist())->deleteById($id);
        echo json_encode(['success' => true]);
    }



    public function deleteUser($id)
    {
        (new User())->deleteById($id);
        echo json_encode(['success' => true]);
    }

    public function setMusician($id)
    {
        (new User())->updateRole($id, 'musician');
        echo json_encode(['success' => true]);
    }
}
