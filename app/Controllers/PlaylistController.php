<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Song;
use App\Models\Playlist;
use League\Plates\Engine;

class PlaylistController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->playlistModel = new Playlist();
        $this->songModel = new Song();
        
    }
    public function showAddSongToPlaylistForm($songId)
    {
        $userId = $_SESSION['user']['id'] ?? null;

        if (!$userId) {
            http_response_code(401); 
            echo "NOT_LOGGED_IN";
            return;
        }

        $playlists = $this->playlistModel->getUserPlaylists($userId);

        echo $this->view->render('layouts/addplaylist', [
            'playlists' => $playlists,
            'songId' => $songId
        ]);
    }
    public function create()
    {
        header('Content-Type: application/json'); 
        $name = $_POST['name'] ?? '';
        $userId = $_SESSION['user']['id'] ?? null;
        $thumbFile = $_FILES['thumbnail'] ?? null;
        $songId = $_POST['song_id'] ?? null;

        if (!$name || !$userId) {
            echo json_encode(['success' => false, 'message' => 'Missing information']);
            return;
        }

        $thumbName = null;
        if ($thumbFile && $thumbFile['error'] === UPLOAD_ERR_OK) {
            $thumbName = time() . '_' . basename($thumbFile['name']);
            move_uploaded_file(
                $thumbFile['tmp_name'],
                __DIR__ . '/../../public/uploads/songs/' . $thumbName
            );
        }

        $this->playlistModel->create($name, $userId, $thumbName);

        echo json_encode(['success' => true, 'song_id' => $songId]);
    }
    public function getSongsByPlaylistId()
    {
        $playlistId = $_GET['id'] ?? null;
        if (!$playlistId) {
            echo json_encode([]);
            return;
        }

        $songs = $this->playlistModel->getSongs($playlistId);

        header('Content-Type: application/json');
        echo json_encode(array_map(function ($s) {
            return [
                'id' => $s['id'],
                'title' => $s['title'],
                'artist' => $s['artist'],
                'thumbnail' => BASE_URL . '/uploads/thumbnails/' . $s['thumbnail'],
                'file' => BASE_URL . '/uploads/songs/' . $s['filename'],
            ];
        }, $songs), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
    public function getRandomSongs() {
        $limit = $_GET['limit'] ?? 6;
        $songs = $this->songModel->getRandomSongs($limit);
    
        echo json_encode(array_map(function ($s) {
            return [
                'id' => $s['id'],
                'title' => $s['title'],
                'artist' => $s['artist'],
                'file' => BASE_URL . '/uploads/songs/' . $s['filename'],
                'thumbnail' => BASE_URL . '/uploads/thumbnails/' . $s['thumbnail']
            ];
        }, $songs), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
    
    public function random()
    {
        $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;

        require_once 'app/models/Song.php';
        $songModel = new Song();
        $songs = $songModel->getRandomSongs($limit);

        header('Content-Type: application/json');
        echo json_encode($songs);
    }
    public function addSongToPlaylist()
    {
        $playlistIds = $_POST['playlist_ids'] ?? [];
        $songId = $_POST['song_id'] ?? null; 

        if (!$songId || empty($playlistIds)) return;

        foreach ($playlistIds as $pid) {
            $success = $this->playlistModel->addSongToPlaylist($pid, $songId);
            if (!$success) {
                error_log("Failed to add song $songId to playlist $pid");
            }
        }

        echo "done";
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
                'thumbnail' => BASE_URL . '/uploads/thumbnails/' . $s['thumbnail'],
                'file' => BASE_URL . '/uploads/songs/' . $s['filename'],
            ];
        }, $songs), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
    public function showPlaylistContainer()
    {
        $playlists = $this->playlistModel->getAllWithUser();

        echo $this->view->render('layouts/playlistcontainer', [
            'playlists' => $playlists
        ]);
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

        echo $this->view->render('playlist  /playlistdisplay', [
            'playlist' => $playlist,
            'songs' => $songs
        ]);
    }

    public function getSongsByArtist($name)
    {
        return $this->playlistModel->getSongsByArtist($name);
    }

    public function getSongsByQuery($type = 'latest')
    {
        return $this->playlistModel->getSongsByQuery($type);
    }

    public function getSongsByUserId($userId)
    {
        return $this->playlistModel->getSongsByUserId($userId);
    }
}
