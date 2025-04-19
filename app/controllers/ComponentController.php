<?php

namespace App\Controllers;

use League\Plates\Engine;

class ComponentController {
    public function load($component) {
        $basePath = __DIR__ . '/../views/';

        switch ($component) {
            case 'login':
                $view = new Engine($basePath . 'auth');
                echo $view->render('login');
                break;
            case 'register':
                $view = new Engine($basePath . 'auth');
                echo $view->render('register');
                break;    
            case 'upload':
                $view = new Engine($basePath . 'components');
                echo $view->render('upload');
                break;


            default:
                http_response_code(404);
                echo "Component not found";
        }
    }
}
