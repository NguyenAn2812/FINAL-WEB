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
