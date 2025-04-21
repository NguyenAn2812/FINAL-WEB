<?php

namespace App\Controllers;
use Core\Database;
use PDO;

class PlaylistController {
    public function getAllSongsAsJson() {
        $db = Database::getInstance();
        $stmt = $db->query("
            SELECT songs.*, users.username AS artist
            FROM songs
            LEFT JOIN users ON songs.user_id = users.id
            ORDER BY songs.created_at DESC
        ");
        $songs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');
        echo json_encode(array_map(function($s) {
            return [
                'id' => $s['id'],
                'title' => $s['title'],
                'artist' => $s['artist'],
                'thumbnail' => BASE_URL . '/uploads/songs/' . $s['thumbnail'],
                'file' => BASE_URL . '/uploads/songs/' . $s['filename'],
            ];
        }, $songs), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
