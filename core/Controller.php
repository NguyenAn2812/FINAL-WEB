<?php

namespace Core;

use League\Plates\Engine;
use App\Models\User;
use App\Models\Song;
use App\Models\Playlist;

class Controller
{
    protected Engine $view;
    protected User $userModel;
    protected Song $songModel;
    protected Playlist $playlistModel;

    public function __construct()
    {
        $this->view = new Engine(__DIR__ . '/../views');
        $this->view->registerFunction('asset', fn($p) => BASE_URL . '/' . ltrim($p, '/'));

        $this->userModel = new User();
        $this->songModel = new Song();
        $this->playlistModel = new Playlist();
    }
}
