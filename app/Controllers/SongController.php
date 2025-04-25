<?php

namespace App\Controllers;

use League\Plates\Engine;
use App\Models\Song;

class SongController
{
    protected $view;
    protected $songModel;

    public function __construct()
    {
        $this->view = new Engine(__DIR__ . '/../views');
        $this->view->registerFunction('asset', fn($p) => BASE_URL . '/' . ltrim($p, '/'));
        $this->songModel = new Song();
    }
    
    public function showSongContainer()
    {
        $songs = $this->songModel->getAllWithArtist();
        echo $this->view->render('layouts/songcontainer', ['songs' => $songs]);
    }

    public function display($id)
    {
        $song = $this->songModel->findWithArtist($id);
        if (!$song) {
            echo "<p class='text-red-500'>Song not found</p>";
            return;
        }

        $related = $this->songModel->getRelatedSongs($id); 

        echo $this->view->render('songs/songdisplay', [
            'song' => $song,
            'songs' => $related
        ]);
    }


    
    public function upload()
    {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Invalid method']);
            return;
        }

        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $musicFile = $_FILES['file'] ?? null;
        $thumbFile = $_FILES['thumbnail'] ?? null;

        if (!$musicFile || $musicFile['error'] !== UPLOAD_ERR_OK || !$thumbFile || $thumbFile['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['success' => false, 'message' => 'Upload failed. Please check the files.']);
            return;
        }

        $musicName = time() . '_' . basename($musicFile['name']);
        $thumbName = time() . '_' . basename($thumbFile['name']);

        $musicDir = __DIR__ . '/../../public/uploads/songs';
        $thumbDir = __DIR__ . '/../../public/uploads/thumbnails';

        if (!is_dir($musicDir)) mkdir($musicDir, 0777, true);
        if (!is_dir($thumbDir)) mkdir($thumbDir, 0777, true);

        move_uploaded_file($musicFile['tmp_name'], $musicDir . '/' . $musicName);
        move_uploaded_file($thumbFile['tmp_name'], $thumbDir . '/' . $thumbName);

        $this->songModel->create([
            'title' => $title,
            'description' => $description,
            'filename' => $musicName,
            'thumbnail' => $thumbName,
            'user_id' => $_SESSION['user']['id'] ?? null
        ]);

        echo json_encode(['success' => true, 'message' => 'Song uploaded successfully']);
    }
    
}
