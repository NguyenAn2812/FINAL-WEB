<?php

namespace App\Controllers;

use Core\Database;
use League\Plates\Engine;
use PDO;
use App\Models\Song;

class ComponentController
{
    private function makeView($path = null): Engine
    {
        $view = new Engine($path ?? (__DIR__ . '/../views'));

        $view->registerFunction('asset', function ($p) {
            return BASE_URL . $p;
        });

        return $view;
    }

    public function load($component)
    {
        switch ($component) {
            case 'login':
                $view = $this->makeView(__DIR__ . '/../views/auth');
                echo $view->render('login');
                break;

            case 'register':
                $view = $this->makeView(__DIR__ . '/../views/auth');
                echo $view->render('register');
                break;

            case 'upload':
                $view = $this->makeView(__DIR__ . '/../views/layouts');
                echo $view->render('upload');
                break;

            case 'songdisplay':
                $id = $_GET['id'] ?? null;
                if (!$id) {
                    echo "<p class='text-red-500'>Song not found.</p>";
                    return;
                }

                $db = Database::getInstance();
                $stmt = $db->prepare("
                    SELECT songs.*, users.username AS artist
                    FROM songs
                    LEFT JOIN users ON songs.user_id = users.id
                    WHERE songs.id = ?
                ");
                $stmt->execute([$id]);
                $song = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$song) {
                    echo "<p class='text-red-500'>Song does not exist.</p>";
                    return;
                }

                $related = $db->prepare("
                    SELECT songs.*, users.username AS artist
                    FROM songs
                    LEFT JOIN users ON songs.user_id = users.id
                    WHERE songs.id != ?
                    ORDER BY RAND() LIMIT 6
                ");
                $related->execute([$id]);
                $relatedSongs = $related->fetchAll(PDO::FETCH_ASSOC);

                $view = $this->makeView();
                echo $view->render('songs/songdisplay', [
                    'song' => $song,
                    'songs' => $relatedSongs 
                ]);
                break;

            case 'home':
                $songModel = new Song();
                $songs = $songModel->getAllWithArtist(); 
                
                $view = $this->makeView();
                
                echo $view->render('layouts/songcontainer', [
                    'songs' => $songs 
                ]);
                break;
            case 'playlistdisplay':
                $id = $_GET['id'] ?? null;
                if (!$id) {
                    echo "<p class='text-red-500'>Playlist not found.</p>";
                    return;
                }
            
                $db = Database::getInstance();
                $stmt = $db->prepare("
                    SELECT playlists.*, users.username 
                    FROM playlists  
                    LEFT JOIN users ON playlists.user_id = users.id 
                    WHERE playlists.id = ?
                ");
                $stmt->execute([$id]);
                $playlist = $stmt->fetch(PDO::FETCH_ASSOC);
            
                if (!$playlist) {
                    echo "<p class='text-red-500'>Playlist không tồn tại.</p>";
                    return;
                }
            
                $songsStmt = $db->prepare("
                    SELECT songs.*, users.username AS artist 
                    FROM playlist_songs 
                    INNER JOIN songs ON playlist_songs.song_id = songs.id 
                    LEFT JOIN users ON songs.user_id = users.id
                    WHERE playlist_songs.playlist_id = ?
                ");
                $songsStmt->execute([$id]);
                $songs = $songsStmt->fetchAll(PDO::FETCH_ASSOC);
            
                $view = $this->makeView();
                echo $view->render('playlist/playlistdisplay', [
                    'playlist' => $playlist,
                    'songs' => $songs
                ]);
                break;
            case 'newfeed':
                $playlist = new \App\Controllers\PlaylistController();
            
                $trendingSongs = $playlist->getSongsByQuery("ORDER BY views DESC LIMIT 6");
                $mtpSongs = $playlist->getSongsByArtist('Sơn Tùng M-TP');
                $personalizedSongs = $playlist->getSongsByUserId($_SESSION['user']['id'] ?? null);
            
                $view = $this->makeView();
                echo $view->render('newfeed/container', [
                    'trendingSongs' => $trendingSongs,
                    'mtpSongs' => $mtpSongs,
                    'personalizedSongs' => $personalizedSongs
                ]);
                break;
                
            default:
                http_response_code(404);
                echo "Component not found";
        }
    }
}
