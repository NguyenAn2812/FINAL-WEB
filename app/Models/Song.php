<?php

namespace App\Models;

use Core\Database;
use PDO;

class Song
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAllWithArtist()
    {
        $stmt = $this->db->query("
            SELECT songs.*, users.username AS artist
            FROM songs
            LEFT JOIN users ON songs.user_id = users.id
            ORDER BY songs.created_at DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findWithArtist($id)
    {
        $stmt = $this->db->prepare("
            SELECT songs.*, users.username AS artist
            FROM songs
            LEFT JOIN users ON songs.user_id = users.id
            WHERE songs.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getRelatedSongs($excludeId, $limit = 6)
    {
        $stmt = $this->db->prepare("
            SELECT songs.*, users.username AS artist
            FROM songs
            LEFT JOIN users ON songs.user_id = users.id
            WHERE songs.id != ?
            ORDER BY RAND() LIMIT ?
        ");
        $stmt->execute([$excludeId, $limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO songs (title, description, filename, thumbnail, user_id) 
            VALUES (?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['title'],
            $data['description'],
            $data['filename'],
            $data['thumbnail'],
            $data['user_id']
        ]);
    }
}
