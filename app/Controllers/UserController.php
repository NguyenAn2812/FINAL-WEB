<?php

namespace App\Controllers;

use App\Models\User;

class UserController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }
    public function showProfile()
    {
        $user = $_SESSION['user'] ?? null;
        if (!$user) {
            header('Location: /');
            return;
        }

        $userModel = new \App\Models\User();
        $songModel = new \App\Models\Song();

        $fullUser = $userModel->findById($user['id']);
        $songs = $songModel->getSongsByUser($user['id']);

        $view = new \League\Plates\Engine(__DIR__ . '/../views/user');
        echo $view->render('profile', [
            'user' => $fullUser,
            'songs' => $songs
        ]);
    }

    public function getAllUsers()
    {
        return $this->userModel->getAllUsers();
    }

    public function findById($id)
    {
        return $this->userModel->findById($id);
    }

    public function findByUsername($username)
    {
        return $this->userModel->findByUsername($username);
    }

    public function createUser($username, $email, $password, $avatar = null)
    {
        return $this->userModel->create($username, $email, $password, $avatar);
    }

    public function updateAvatar($id, $avatar)
    {
        return $this->userModel->updateAvatar($id, $avatar);
    }

    public function changePassword($id, $newPassword)
    {
        return $this->userModel->changePassword($id, $newPassword);
    }

    public function verifyPassword($plain, $hashed)
    {
        return password_verify($plain, $hashed);
    }
}
