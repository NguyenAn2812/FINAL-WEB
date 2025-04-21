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

    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM songs WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByPlaylist($playlistId)
    {
        $stmt = $this->db->prepare("
            SELECT songs.* 
            FROM songs 
            INNER JOIN playlist_songs ON songs.id = playlist_songs.song_id 
            WHERE playlist_songs.playlist_id = ?
        ");
        $stmt->execute([$playlistId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
