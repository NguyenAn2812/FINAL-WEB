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
            case 'profile':
                (new \App\Controllers\UserController())->showProfile();
                break;
            case 'login':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    (new \App\Controllers\AuthController())->login();
                    return;
                }
                $view = $this->makeView(__DIR__ . '/../views/auth');
                echo $view->render('login');
                break;

            case 'register':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    (new \App\Controllers\AuthController())->register();
                    return;
                }
            
                $view = $this->makeView(__DIR__ . '/../views/auth');
                echo $view->render('register');
                break;
                
            case 'upload':
                echo $this->makeView(__DIR__ . '/../views/layouts')->render('upload');
                break;
            case 'navbar':
                echo $this->makeView(__DIR__ . '/../views/layouts')->render('navbar');
                break;
            case 'songdisplay':
                $id = $_GET['id'] ?? null;
                if (!$id) {
                    echo "<p class='text-red-500'>Song not found.</p>";
                    return;
                }
                (new \App\Controllers\SongController())->display($id);
                break;

            case 'home':
                (new \App\Controllers\SongController())->showSongContainer();
                (new \App\Controllers\PlaylistController())->showPlaylistContainer();
                (new \App\Controllers\UserController())->showMusicianContainer();
                break;
            case 'playlistdisplay':
                $id = $_GET['id'] ?? null;
                if (!$id) {
                    echo "<p class='text-red-500'>Playlist not found.</p>";
                    return;
                }
            
                $playlistModel = new \App\Models\Playlist();
                $playlist = $playlistModel->find($id);
            
                if (!$playlist) {
                    echo "<p class='text-red-500'>Playlist không tồn tại.</p>";
                    return;
                }
            
                $songs = $playlistModel->getSongs($id);
            
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
