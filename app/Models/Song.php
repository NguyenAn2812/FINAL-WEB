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
    public function all(){
        $sql = "SELECT * FROM songs";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getRandomSongs($limit = 10)
    {
        $stmt = $this->db->prepare("
            SELECT songs.*, users.username AS artist
            FROM songs
            JOIN users ON songs.user_id = users.id
            ORDER BY RAND()
            LIMIT ?
        ");
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAll()
    {
        $sql = "SELECT COUNT(*) as total FROM songs";
        return $this->db->query($sql)->fetch(\PDO::FETCH_ASSOC)['total'] ?? 0;
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
    public function deleteById($id)
    {
        $song = $this->findById($id);
        if ($song && isset($song['file'])) {
            $filePath = __DIR__ . '/../uploads/songs/' . $song['file'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        $stmt = $this->db->prepare("DELETE FROM songs WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function getSongsByUser($userId)
    {
        $stmt = $this->db->prepare("
            SELECT songs.*, users.username AS artist
            FROM songs
            JOIN users ON songs.user_id = users.id
            WHERE songs.user_id = ?
            ORDER BY songs.created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function getRelatedSongs($excludeId, $limit = 6)
    {
        $limit = intval($limit); 
        $stmt = $this->db->prepare("
            SELECT songs.*, users.username AS artist
            FROM songs
            LEFT JOIN users ON songs.user_id = users.id
            WHERE songs.id != ?
            ORDER BY RAND()
            LIMIT $limit
        ");
        $stmt->execute([$excludeId]);
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
