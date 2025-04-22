<?php

namespace App\Controllers;

use App\Models\Song;
use App\Models\Playlist;
use League\Plates\Engine;
use Core\Database;

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
        var_dump($playlists);
        echo $this->view->render('layouts/playlistdisplay', ['playlists' => $playlists]);
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
    public function getSongsByArtist($name) {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            SELECT songs.*, users.username AS artist
            FROM songs
            LEFT JOIN users ON songs.user_id = users.id
            WHERE users.username = ?
            ORDER BY songs.created_at DESC
        ");
        $stmt->execute([$name]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getSongsByQuery($orderClause = '') {
        $db = Database::getInstance();
        $stmt = $db->query("
            SELECT songs.*, users.username AS artist
            FROM songs
            LEFT JOIN users ON songs.user_id = users.id
            $orderClause
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getSongsByUserId($userId) {
        if (!$userId) return [];
    
        $db = Database::getInstance();
        $stmt = $db->prepare("
            SELECT songs.*, users.username AS artist
            FROM songs
            LEFT JOIN users ON songs.user_id = users.id
            WHERE user_id = ?
            ORDER BY songs.created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
