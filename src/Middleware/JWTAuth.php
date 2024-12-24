<?php

namespace App\Middleware;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTAuth
{
    private static $secretKey = 'secret-key-from-env';

    public static function generateToken($user)
    {
        $payload = [
            'iss' => 'vending-machine',
            'aud' => 'vending-machine',
            'iat' => time(),
            'exp' => time() + 36000,
            'sub' => $user['id'],
        ];

        return JWT::encode($payload, self::$secretKey, 'HS256');
    }

    public static function validateToken($token)
    {
        try {
            return JWT::decode($token, new Key(self::$secretKey, 'HS256'));
        } catch (\Exception $e) {
            return false;
        }
    }
}
