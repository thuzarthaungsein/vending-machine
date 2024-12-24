<?php

namespace App\Models;

use PDO;

class User
{
    private $conn;
    private $table = "users";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function register($username, $password, $role)
    {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO ". $this->table ." (username, password, role) VALUES (:username, :password, :role)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':username' => $username, ':password' => $hashed_password, ':role' => $role]);
    }

    public function checkUnique($username)
    {
        $sql = "SELECT * FROM ". $this->table ." WHERE username = :username";
        $checkStmt = $this->conn->prepare($sql);
        $checkStmt->execute(['username' => $username]);

        if ($checkStmt->rowCount() < 1) {
            return true;
        }

        return false;
    }

    public function login($username, $password)
    {
        $sql = "SELECT * FROM ". $this->table ." WHERE username = :username";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user'] = $user;
            return true;
        }
        return false;
    }
}
