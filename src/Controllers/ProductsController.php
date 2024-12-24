<?php

namespace App\Controllers;

use App\Models\Product;
use App\Config\Database;
use App\Models\Transaction;

class ProductsController extends BaseController
{
    private $conn;
    private $model;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
        $this->model = new Product($this->conn);
    }

    public function list()
    {
        $data = $this->model->list();
        $this->view('/admin/product/list', $data);
    }

    public function shop()
    {
        $data = $this->model->list();
        $this->view('/user/shop', $data);
    }

    public function show($id)
    {
        //
    }

    public function create()
    {
        $this->view('/admin/product/create');
    }

    public function edit($id)
    {
        $data = $this->model->show($id);
        $this->view('/admin/product/edit', $data);
    }

    public function update($id)
    {
        $name = trim($_POST['name']);
        $price = (float)$_POST['price'];
        $availableQty = (int)$_POST['available_qty'];

        $this->model->update($id, $name, $price, $availableQty);

        $_SESSION['success'] = "Product updated successfully.";
        header("Location: /products");
        exit;
    }

    public function store()
    {
        $name = trim($_POST['name']);
        $price = (float)$_POST['price'];
        $availableQty = (int)$_POST['available_qty'];

        if (empty($name) || $price <= 0 || $availableQty < 0) {
            $_SESSION['error'] = "Please ensure all fields are valid.";
            header("Location: /products/create");
            exit;
        }

        $this->model->create($name, $price, $availableQty);

        $_SESSION['success'] = "Product created successfully.";
        header("Location: /products");
        exit;
    }

    public function purchase()
    {
        $productId = $_POST['product_id'];
        $quantity = (int)$_POST['quantity'];

        if ($quantity <= 0) {
            $_SESSION['error'] = "Invalid quantity.";
            header("Location: /shop");
            exit;
        }

        $productDetails = $this->model->show($productId);

        if (!$productDetails || $productDetails['available_qty'] < $quantity) {
            $_SESSION['error'] = "Insufficient stock or product not found.";
            header("Location: /shop");
            exit;
        }

        $transaction = new Transaction($this->conn);
        $transaction->add($_SESSION['user']['id'], $productId, $quantity);

        $_SESSION['success'] = "Purchase successful!";
        header("Location: /shop");
        exit;
    }

    public function destroy($id)
    {
        $this->model->delete($id);
        $_SESSION['success'] = "Delete successful!";
        header("Location: /products");
        exit;
    }

}
