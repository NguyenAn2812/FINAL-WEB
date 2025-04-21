<?php

namespace App\Models;

use Core\Database;
use PDO;

class Playlist
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAllWithUser()
    {
        $stmt = $this->db->query("
            SELECT playlists.*, users.username AS owner
            FROM playlists
            LEFT JOIN users ON playlists.user_id = users.id
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM playlists WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getSongs($id)
    {
        $stmt = $this->db->prepare("
            SELECT songs.*
            FROM songs
            INNER JOIN playlist_songs ON songs.id = playlist_songs.song_id
            WHERE playlist_songs.playlist_id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
