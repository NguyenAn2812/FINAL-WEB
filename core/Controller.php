<?php

namespace Core;

use App\Models\User;
use App\Models\Song;
use App\Models\Playlist;

class BaseController extends Controller
{
    protected $userModel;
    protected $songModel;
    protected $playlistModel;

    public function __construct()
    {
        $this->view = new Engine(__DIR__ . '/../views');
        $this->view->registerFunction('asset', fn($path) => BASE_URL . '/' . ltrim($path, '/'));
        $this->userModel = new User();
        $this->songModel = new Song();
        $this->playlistModel = new Playlist();
    }
}
