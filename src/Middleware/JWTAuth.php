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

    public function handle(): bool
    {
        $headers = getallheaders();
        if (!isset($headers['Authorization'])) {
            return false;
        }

        $authHeader = $headers['Authorization'];
        [$type, $token] = explode(' ', $authHeader);

        if ($type !== 'Bearer' || empty($token)) {
            return false;
        }

        try {
            return JWT::decode($token, new Key(self::$secretKey, 'HS256'));
        } catch (\Exception $e) {
            return false;
        }
    }
}
