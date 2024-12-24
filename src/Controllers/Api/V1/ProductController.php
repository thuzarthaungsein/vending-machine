<?php

namespace App\Controllers\Api\V1;

use App\Models\Product;
use App\Helpers\Response;
use App\Models\Transaction;

class ProductController
{
    public function list()
    {
        $products = Product::all();
        return Response::json($products);
    }

    public function purchase($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $product = Product::show($id);
        if (!$product || $product['available_qty'] < $data['quantity']) {
            Response::json(['message' => 'Insufficient stock'], 400);
            return;
        }

        $product['available_qty'] -= $data['quantity'];
        Transaction::add($_SESSION['user']['id'], $id, $data['quantity']);

        Response::json(['message' => 'Purchase successful']);
    }
}
