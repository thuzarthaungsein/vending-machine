<?php

namespace App\Models;

use PDO;
use Exception;

class Transaction
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function add($user_id, $product_id, $quantity)
    {
        $sql = "SELECT price, available_qty FROM products WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $product_id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product['available_qty'] >= $quantity) {
            $total_price = $product['price'] * $quantity;
            $this->conn->beginTransaction();
            try {
                $sql = "INSERT INTO transactions (user_id, product_id, quantity, total_price) 
                        VALUES (:user_id, :product_id, :quantity, :total_price)";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([
                    ':user_id' => $user_id,
                    ':product_id' => $product_id,
                    ':quantity' => $quantity,
                    ':total_price' => $total_price
                ]);

                $available = $product['available_qty'] - $quantity;
                $sql = "UPDATE products SET available_qty = :qty WHERE id = :id";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([':qty' => $available, ':id' => $product_id]);

                $this->conn->commit();
            } catch (Exception $e) {
                $this->conn->rollBack();
                throw $e;
            }
        } else {
            throw new Exception('Insufficient stock');
        }
    }
}
