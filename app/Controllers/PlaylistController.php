<?php

namespace App\Controllers;

use App\Models\Song;

class PlaylistController
{
    protected $songModel;

    public function __construct()
    {
        $this->songModel = new Song();
    }

    public function getAllSongsAsJson()
    {
        $songs = $this->songModel->getAllWithArtist();

        header('Content-Type: application/json');
        echo json_encode(array_map(function ($s) {
            return [
                'id' => $s['id'],
                'title' => $s['title'],
                'artist' => $s['artist'],
                'thumbnail' => BASE_URL . '/uploads/songs/' . $s['thumbnail'],
                'file' => BASE_URL . '/uploads/songs/' . $s['filename'],
            ];
        }, $songs), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
    public function listAll()
    {
        $playlists = $this->playlistModel->getAll();
        require_once __DIR__ . '/../views/playlist/list.php';
    }
}
