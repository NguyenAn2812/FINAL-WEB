<?php

namespace App\Models;

use Core\Database;
use PDO;

class User
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByUsername($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function changeUsername($id, $username)
    {
        $stmt = $this->db->prepare("UPDATE users SET username = ? WHERE id = ?");
        return $stmt->execute([$username, $id]);
    }

    public function getAllUsers()
    {
        $stmt = $this->db->query("SELECT * FROM users ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($username, $email, $password, $avatar = null)
    {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("
            INSERT INTO users (username, email, password, avatar) 
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([$username, $email, $hashed, $avatar]);
    }

    public function updateAvatar($id, $avatar)
    {
        $stmt = $this->db->prepare("UPDATE users SET avatar = ? WHERE id = ?");
        return $stmt->execute([$avatar, $id]);
    }

    public function changePassword($id, $newPassword)
    {
        $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE id = ?");
        return $stmt->execute([$hashed, $id]);
    }
}
