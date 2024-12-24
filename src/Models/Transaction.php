<?php

namespace App\Models;

use App\Config\Database;
use PDO;
use Exception;

class Transaction
{
    private static $conn;

    public static function init()
    {
        if (!self::$conn) {
            $database = new Database();
            self::$conn = $database->connect();
        }
    }

    public static function add($user_id, $product_id, $quantity)
    {
        self::init();

        $sql = "SELECT price, available_qty FROM products WHERE id = :id";
        $stmt = self::$conn->prepare($sql);
        $stmt->execute([':id' => $product_id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product['available_qty'] >= $quantity) {
            $total_price = $product['price'] * $quantity;
            self::$conn->beginTransaction();
            try {
                $sql = "INSERT INTO transactions (user_id, product_id, quantity, total_price) 
                        VALUES (:user_id, :product_id, :quantity, :total_price)";
                $stmt = self::$conn->prepare($sql);
                $stmt->execute([
                    ':user_id' => $user_id,
                    ':product_id' => $product_id,
                    ':quantity' => $quantity,
                    ':total_price' => $total_price
                ]);

                $available = $product['available_qty'] - $quantity;
                $sql = "UPDATE products SET available_qty = :qty WHERE id = :id";
                $stmt = self::$conn->prepare($sql);
                $stmt->execute([':qty' => $available, ':id' => $product_id]);

                self::$conn->commit();
            } catch (Exception $e) {
                self::$conn->rollBack();
                throw $e;
            }
        } else {
            throw new Exception('Insufficient stock');
        }
    }
}
