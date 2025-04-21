<?php

namespace App\Controllers;
use Core\Database;
use League\Plates\Engine;
use PDO;
class ComponentController {
    public function load($component) {
        $basePath = __DIR__ . '/../views/';

        switch ($component) {
            case 'login':
                $view = new Engine($basePath . 'auth');
                echo $view->render('login');
                break;
            case 'register':
                $view = new Engine($basePath . 'auth');
                echo $view->render('register');
                break;    
            case 'upload':
                $view = new Engine($basePath . 'layouts');
                echo $view->render('upload');
                break;
            case 'songdisplay':
                $id = $_GET['id'] ?? null;
                if (!$id) {
                    echo "<p class='text-red-500'>Không tìm thấy bài hát.</p>";
                    return;
                }
            
                $db = \Core\Database::getInstance();
                $stmt = $db->prepare("SELECT songs.*, users.username AS artist FROM songs LEFT JOIN users ON songs.user_id = users.id WHERE songs.id = ?");
                $stmt->execute([$id]);
                $song = $stmt->fetch(PDO::FETCH_ASSOC);
            
                $related = $db->prepare("SELECT songs.*, users.username AS artist FROM songs LEFT JOIN users ON songs.user_id = users.id WHERE songs.id != ? ORDER BY RAND() LIMIT 6");
                $related->execute([$id]);
                $relatedSongs = $related->fetchAll(PDO::FETCH_ASSOC);
            
                $view = new \League\Plates\Engine(__DIR__ . '/../views');
                echo $view->render('songs/songdisplay', ['song' => $song, 'relatedSongs' => $relatedSongs]);
                break;

            case 'home':
                $view = new \League\Plates\Engine(__DIR__ . '/../views');
                echo $view->render('layouts/songcontainer');
                break;
            default:
                http_response_code(404);
                echo "Component not found";
        }
    }
}
