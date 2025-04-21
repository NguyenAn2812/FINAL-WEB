<?php

namespace App\Controllers;
use Core\Database;

use League\Plates\Engine;
use PDO;

class SongController {
    protected $db;
    protected $view;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->view = new Engine(__DIR__ . '/../views/layouts');
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

        // Validate file
        if (!$musicFile || $musicFile['error'] !== UPLOAD_ERR_OK || !$thumbFile || $thumbFile['error'] !== UPLOAD_ERR_OK) {
            echo " Upload failed. Please check the file.";
            return;
        }

        
        // Create safe file name
        $musicName = time() . '_' . basename($musicFile['name']);
        $thumbName = time() . '_' . basename($thumbFile['name']);

        $musicPath = 'uploads/songs/' . $musicName;
        $thumbPath = 'uploads/songs/' . $thumbName;

        
        // Move files
        move_uploaded_file($musicFile['tmp_name'], $musicPath);
        move_uploaded_file($thumbFile['tmp_name'], $thumbPath);

        
        // Write to database
        $stmt = $this->db->prepare("INSERT INTO songs (title, description, filename, thumbnail, user_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $title,
            $description,
            $musicName,
            $thumbName,
            $_SESSION['user']['id'] ?? null
        ]);
        header("Location: " . BASE_URL);


    }
}
