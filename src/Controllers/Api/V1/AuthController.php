<?php

namespace App\Controllers\Api\V1;

use App\Config\Database;
use App\Models\User;
use App\Middleware\JWTAuth;
use App\Helpers\Response;

class AuthController
{
    public function login()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $user = User::find($data['username'] ?? null);
        if ($user && password_verify($data['password'], $user['password'])) {
            $token = JWTAuth::generateToken($user);
            Response::json(['token' => $token]);
        } else {
            Response::json(['message' => 'Invalid credentials']); //401
        }
    }
}
