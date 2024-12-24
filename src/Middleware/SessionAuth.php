<?php

namespace App\Middleware;

class SessionAuth
{
    public function handle(): bool
    {
        return isset($_SESSION['user']);
    }

    public function isAdmin()
    {
        return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
    }
}
