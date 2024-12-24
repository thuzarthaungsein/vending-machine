<?php

namespace App\Models;

use App\Config\Database;
use PDO;
use Exception;

class User
{
    private static $conn;
    private static $table = "users";

    public static function init()
    {
        if (!self::$conn) {
            $database = new Database();
            self::$conn = $database->connect();
        }
    }

    public static function register($username, $password, $role)
    {
        self::init();

        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        self::$conn->beginTransaction();
        try {
            $sql = "INSERT INTO ". self::$table ." (username, password, role) VALUES (:username, :password, :role)";
            $stmt = self::$conn->prepare($sql);
            $stmt->execute([':username' => $username, ':password' => $hashed_password, ':role' => $role]);
            self::$conn->commit();
        } catch (Exception $e) {
            self::$conn->rollBack();
            throw $e;
        }
    }

    public static function checkUnique($username)
    {
        self::init();

        $sql = "SELECT * FROM ". self::$table ." WHERE username = :username";
        $checkStmt = self::$conn->prepare($sql);
        $checkStmt->execute(['username' => $username]);

        if ($checkStmt->rowCount() < 1) {
            return true;
        }

        return false;
    }

    public static function login($username, $password)
    {
        self::init();

        $sql = "SELECT * FROM ". self::$table ." WHERE username = :username";
        $stmt = self::$conn->prepare($sql);
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user'] = $user;
            return true;
        }
        return false;
    }

    public static function find($username)
    {
        self::init();

        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = self::$conn->prepare($sql);
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }
}
