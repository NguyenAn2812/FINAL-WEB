<?php

namespace App\Controllers;

use Core\Database;
use League\Plates\Engine;
use App\Models\Song;

class SongController
{
    protected $db;
    protected $view;
    protected $songModel;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->view = new Engine(__DIR__ . '/../views/layouts');
        $this->songModel = new Song();
    }

    public function upload() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo "Invalid method.";
            return;
        }
    
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $musicFile = $_FILES['file'] ?? null;
        $thumbFile = $_FILES['thumbnail'] ?? null;
    
        // DEBUG
        file_put_contents(__DIR__ . '/../../upload_debug.log', print_r($_FILES, true));
    
        if (!$musicFile || $musicFile['error'] !== UPLOAD_ERR_OK || !$thumbFile || $thumbFile['error'] !== UPLOAD_ERR_OK) {
            file_put_contents(__DIR__ . '/../../upload_debug.log', "Upload failed due to file error\n", FILE_APPEND);
            echo "Upload failed. Please check the file.";
            return;
        }
    
        $musicName = time() . '_' . basename($musicFile['name']);
        $thumbName = time() . '_' . basename($thumbFile['name']);
    
        // Use full path (correct!)
        $musicDir = __DIR__ . '/../../public/uploads/songs';
        $thumbDir = __DIR__ . '/../../public/uploads/thumbnails';
    
        if (!is_dir($musicDir)) mkdir($musicDir, 0777, true);
        if (!is_dir($thumbDir)) mkdir($thumbDir, 0777, true);
    
        if (!is_writable($musicDir) || !is_writable($thumbDir)) {
            file_put_contents(__DIR__ . '/../../upload_debug.log', "Folder not writable\n", FILE_APPEND);
            echo "Upload failed. Folder not writable.";
            return;
        }
    
        $musicPath = $musicDir . '/' . $musicName;
        $thumbPath = $thumbDir . '/' . $thumbName;
    
        if (!move_uploaded_file($musicFile['tmp_name'], $musicPath)) {
            file_put_contents(__DIR__ . '/../../upload_debug.log', "Failed to move MP3 file\n", FILE_APPEND);
            echo "Upload failed: cannot move mp3.";
            return;
        }
    
        if (!move_uploaded_file($thumbFile['tmp_name'], $thumbPath)) {
            file_put_contents(__DIR__ . '/../../upload_debug.log', "Failed to move thumbnail\n", FILE_APPEND);
            echo "Upload failed: cannot move thumbnail.";
            return;
        }
    
        Song::create([
            'title' => $title,
            'description' => $description,
            'filename' => $musicName,
            'thumbnail' => $thumbName,
            'user_id' => $_SESSION['user']['id'] ?? null
        ]);
    
        file_put_contents(__DIR__ . '/../../upload_debug.log', "Upload OK\n", FILE_APPEND);
        header("Location: " . BASE_URL);
    }
    
    
}
