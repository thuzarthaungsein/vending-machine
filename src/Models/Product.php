<?php

namespace App\Models;

use PDO;

class Product
{
    private $conn;
    private $table = "products";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function show($id)
    {
        $sql = "SELECT * FROM ". $this->table ." WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($name, $price, $available_qty)
    {
        $sql = "INSERT INTO ". $this->table ." (name, price, available_qty) VALUES (:name, :price, :qty)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':name' => $name, ':price' => $price, ':qty' => $available_qty]);
    }

    public function list()
    {
        $sql = "SELECT * FROM ". $this->table;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $name, $price, $available_qty)
    {
        $sql = "UPDATE ". $this->table ." SET name = :name, price = :price, available_qty = :qty WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':name' => $name, ':price' => $price, ':qty' => $available_qty, ':id' => $id]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM ". $this->table ." WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
    }
}
