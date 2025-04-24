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
    public function updateProfile()
    {
        $id = $_SESSION['user']['id'];
        $username = $_POST['username'] ?? '';
        $current = $_POST['current_password'] ?? '';
        $new = $_POST['new_password'] ?? '';

        $userModel = new \App\Models\User();
        $user = $userModel->findById($id);

        if (!empty($new)) {
            if (!password_verify($current, $user['password'])) {
                echo json_encode(['success' => false, 'message' => 'Incorrect current password']);
                return;
            }
            $userModel->changePassword($id, $new);
        }

        if ($username !== $user['username']) {
            $userModel->changeUsername($id, $username);
            $_SESSION['user']['username'] = $username;
        }

        if (!empty($_FILES['avatar']['name'])) {
            $file = $_FILES['avatar'];
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = 'avatar_' . time() . '.' . $ext;
            move_uploaded_file($file['tmp_name'], __DIR__ . '/../../public/uploads/avatars/' . $filename);

            $userModel->updateAvatar($id, $filename);
            $_SESSION['user']['avatar'] = $filename;
        }

        echo json_encode(['success' => true]);
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
