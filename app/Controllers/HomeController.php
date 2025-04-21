<?php

namespace App\Controllers;

use League\Plates\Engine;

class HomeController {
    protected $view;

    public function __construct() {
        $this->view = new Engine(__DIR__ . '/../views');
    }

    public function index() {
        echo $this->view->render('home', ['title' => 'Home']);
    }
}