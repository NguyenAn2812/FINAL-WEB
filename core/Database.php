<?php
class Database {
    protected $conn;

    public function __construct() {
        $this->conn = new PDO("mysql:host=localhost;dbname=mydb", "root", "");
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getConnection() {
        return $this->conn;
    }
}
