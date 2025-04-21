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
        $this->userModel = new User();
        $this->songModel = new Song();
        $this->playlistModel = new Playlist();
    }
}
