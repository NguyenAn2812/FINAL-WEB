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

    public function getSongs($playlistId)
    {
        $stmt = $this->db->prepare("
            SELECT songs.*, users.username AS artist
            FROM songs
            INNER JOIN playlist_songs ON songs.id = playlist_songs.song_id
            LEFT JOIN users ON songs.user_id = users.id
            WHERE playlist_songs.playlist_id = ?
        ");
        $stmt->execute([$playlistId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSongsByArtist($artistName)
    {
        $stmt = $this->db->prepare("
            SELECT songs.*, users.username AS artist
            FROM songs
            LEFT JOIN users ON songs.user_id = users.id
            WHERE users.username = ?
            ORDER BY songs.created_at DESC
        ");
        $stmt->execute([$artistName]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSongsByUserId($userId)
    {
        $stmt = $this->db->prepare("
            SELECT songs.*, users.username AS artist
            FROM songs
            LEFT JOIN users ON songs.user_id = users.id
            WHERE songs.user_id = ?
            ORDER BY songs.created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSongsByQuery($type = 'latest')
    {
        $orderClause = match ($type) {
            'popular' => 'ORDER BY songs.views DESC',
            default => 'ORDER BY songs.created_at DESC',
        };

        $stmt = $this->db->query("
            SELECT songs.*, users.username AS artist
            FROM songs
            LEFT JOIN users ON songs.user_id = users.id
            $orderClause
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getUserPlaylists($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM playlists WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
