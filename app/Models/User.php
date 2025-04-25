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
    public function all()
    {
        $sql = "SELECT * FROM users";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
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
    public function countAll()
    {
        $sql = "SELECT COUNT(*) as total FROM users";
        return $this->db->query($sql)->fetch(\PDO::FETCH_ASSOC)['total'] ?? 0;
    }

    public function deleteById($id)
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function updateRole($id, $role)
    {
        $stmt = $this->db->prepare("UPDATE users SET role = ? WHERE id = ?");
        $stmt->execute([$role, $id]);
    }
    public function getTopUploader()
    {
        $sql = "
            SELECT users.username, COUNT(songs.id) as count 
            FROM users 
            JOIN songs ON users.id = songs.user_id 
            GROUP BY users.id 
            ORDER BY count DESC 
            LIMIT 1
        ";
        return $this->db->query($sql)->fetch(\PDO::FETCH_ASSOC);
    }
}
