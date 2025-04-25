<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Song;
use App\Models\Playlist;

class AdminController
{
    public function index()
    {
        $userModel = new User();
        $songModel = new Song();
        $playlistModel = new Playlist();

        $users = $userModel->getAllUsers();
        $songs = $songModel->getAllSongs();
        $playlists = $playlistModel->getAllPlaylists();

        require_once '../app/views/admin/admin.php';
    }
}
