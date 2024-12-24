<?php

namespace App\Models;

use App\Config\Database;
use PDO;
use Exception;

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

        self::$conn->beginTransaction();
        try {
            $sql = "INSERT INTO ". self::$table ." (name, price, available_qty) VALUES (:name, :price, :qty)";
            $stmt = self::$conn->prepare($sql);
            $stmt->execute([':name' => $name, ':price' => $price, ':qty' => $available_qty]);
            self::$conn->commit();
        } catch (Exception $e) {
            self::$conn->rollBack();
            throw $e;
        }

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

        self::$conn->beginTransaction();
        try {
            $sql = "UPDATE ". self::$table ." SET name = :name, price = :price, available_qty = :qty WHERE id = :id";
            $stmt = self::$conn->prepare($sql);
            $stmt->execute([':name' => $name, ':price' => $price, ':qty' => $available_qty, ':id' => $id]);
            self::$conn->commit();
        } catch (Exception $e) {
            self::$conn->rollBack();
            throw $e;
        }
    }

    public static function delete($id)
    {
        self::init();

        self::$conn->beginTransaction();
        try {
            $sql = "DELETE FROM ". self::$table ." WHERE id = :id";
            $stmt = self::$conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            self::$conn->commit();
        } catch (Exception $e) {
            self::$conn->rollBack();
            throw $e;
        }
    }
}
