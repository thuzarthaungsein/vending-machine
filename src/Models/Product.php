<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class Product
{
    private static $conn;
    private static $table = "products";

    public static function init()
    {
        if (!self::$conn) {
            $database = new Database();
            self::$conn = $database->connect();
        }
    }

    public static function show($id)
    {
        self::init();

        $sql = "SELECT * FROM ". self::$table ." WHERE id=:id";
        $stmt = self::$conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($name, $price, $available_qty)
    {
        self::init();

        $sql = "INSERT INTO ". self::$table ." (name, price, available_qty) VALUES (:name, :price, :qty)";
        $stmt = self::$conn->prepare($sql);
        $stmt->execute([':name' => $name, ':price' => $price, ':qty' => $available_qty]);
    }

    public static function all()
    {
        self::init();

        $sql = "SELECT * FROM ". self::$table;
        $stmt = self::$conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function update($id, $name, $price, $available_qty)
    {
        self::init();

        $sql = "UPDATE ". self::$table ." SET name = :name, price = :price, available_qty = :qty WHERE id = :id";
        $stmt = self::$conn->prepare($sql);
        $stmt->execute([':name' => $name, ':price' => $price, ':qty' => $available_qty, ':id' => $id]);
    }

    public static function delete($id)
    {
        self::init();

        $sql = "DELETE FROM ". self::$table ." WHERE id = :id";
        $stmt = self::$conn->prepare($sql);
        $stmt->execute([':id' => $id]);
    }
}
