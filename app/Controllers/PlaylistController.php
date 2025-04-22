<?php

namespace App\Controllers;

use App\Models\Song;
use App\Models\Playlist;
use League\Plates\Engine;

class PlaylistController
{
    protected $playlistModel;
    protected $songModel;
    protected $view;

    public function __construct()
    {
        $this->playlistModel = new Playlist();
        $this->songModel = new Song();
        $this->view = new Engine(__DIR__ . '/../views');
        $this->view->registerFunction('asset', fn($p) => BASE_URL . '/' . ltrim($p, '/'));
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

    public function listContainer()
    {
        $playlists = $this->playlistModel->getAllWithUser();
        echo $this->view->render('layouts/listcontainer', ['playlists' => $playlists]);
    }

    public function display($id)
    {
        $playlist = $this->playlistModel->find($id);
        $songs = $this->playlistModel->getSongs($id);

        echo $this->view->render('playlist/playlistdisplay', [
            'playlist' => $playlist,
            'songs' => $songs
        ]);
    }
}
