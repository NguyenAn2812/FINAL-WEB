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
        echo "<pre>";
        var_dump($_FILES);
        echo "</pre>";
        exit;
        if (!$musicFile || $musicFile['error'] !== UPLOAD_ERR_OK || !$thumbFile || $thumbFile['error'] !== UPLOAD_ERR_OK) {
            echo "Upload failed. Please check the file.";
            return;
        }
    
        $musicName = time() . '_' . basename($musicFile['name']);
        $thumbName = time() . '_' . basename($thumbFile['name']);
    
        if (!is_dir('uploads/songs')) {
            mkdir('uploads/songs', 0777, true);
        }
        if (!is_writable('uploads/songs')) {
            echo "Folder is not writable.";
        }
    
        $musicPath = 'uploads/songs/' . $musicName;
        $thumbPath = 'uploads/songs/' . $thumbName;
    
        if (!move_uploaded_file($musicFile['tmp_name'], $musicPath) ||
            !move_uploaded_file($thumbFile['tmp_name'], $thumbPath)) {
            echo "Upload failed. Cannot move files.";
            return;
        }
    
        \App\Models\Song::create([
            'title' => $title,
            'description' => $description,
            'filename' => $musicName,
            'thumbnail' => $thumbName,
            'user_id' => $_SESSION['user']['id'] ?? null
        ]);
    
        header("Location: " . BASE_URL);
    }
    
}
