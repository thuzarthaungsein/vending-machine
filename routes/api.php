<?php

use App\Controllers\ProductsController;

return [
    [
        'method' => 'GET',
        'path' => '/api/products',
        'handler' => [ProductsController::class, 'list'],
    ],
    [
        'method' => 'POST',
        'path' => '/api/products/purchase',
        'handler' => [ProductsController::class, 'purchase'],
    ],
];
