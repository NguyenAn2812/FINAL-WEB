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
        $stmt = $this->db->prepare("
            SELECT playlists.*, users.username AS creator
            FROM playlists
            JOIN users ON playlists.user_id = users.id
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT playlists.*, users.username AS owner
                                    FROM playlists
                                    LEFT JOIN users ON playlists.user_id = users.id
                                    WHERE playlists.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getSongs($id)
    {
        $stmt = $this->db->prepare("
            SELECT songs.*, users.username AS artist
            FROM playlist_songs
            INNER JOIN songs ON playlist_songs.song_id = songs.id
            LEFT JOIN users ON songs.user_id = users.id
            WHERE playlist_songs.playlist_id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function addSongToPlaylist($playlistId, $songId)
    {
        $stmt = $this->db->prepare("
            INSERT IGNORE INTO playlist_songs (playlist_id, song_id)
            VALUES (?, ?)
        ");
        return $stmt->execute([$playlistId, $songId]);
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
    public function create($name, $userId, $thumbnail = null)
    {
        $stmt = $this->db->prepare("
            INSERT INTO playlists (name, user_id, thumbnail)
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([$name, $userId, $thumbnail]);
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
