<?php

namespace App\Controllers;

use App\Config\Database;
use App\Models\User;
use PDOException;

class AuthController extends BaseController
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function showLoginForm()
    {
        $this->view('login');
    }

    public function showRegisterForm()
    {
        $this->view('register');
    }

    public function login()
    {
        $username = $_POST['username'] ?? null;
        $password = $_POST['password'] ?? null;
        $user = new User($this->conn);
        if ($user->login($username, $password)) {
            if ($_SESSION['user']['role'] === 'admin') {
                header("Location: /admin/dashboard");
                exit;
            }
            header("Location: /shop");
            exit;
        }

        $_SESSION['error'] = "Login Failed!";
        header("Location: /login");
        exit;
    }

    public function logout()
    {
        session_destroy();
        header("Location: /login");
    }

    public function register()
    {
        $username = $_POST['username'] ?? null;
        $password = $_POST['password'] ?? null;
        $confirmPassword = $_POST['confirm_password'] ?? null;
        $role = $_POST['role'] ?? 'user';

        if ($password !== $confirmPassword) {
            $_SESSION['error'] = "Passwords do not match";
        } elseif (strlen($password) < 6) {
            $_SESSION['error'] = "Password must be at least 6 characters";
        } else {
            try {
                $user = new User($this->conn);
                if (!$user->checkUnique($username)) {
                    $_SESSION['error'] = "Username already exists!";
                    header("Location: /register");
                    exit;
                }

                $user->register($username, $password, $role);

                $_SESSION['success'] = "Registration successful!";
                header("Location: /login");
                exit;

            } catch (PDOException $e) {
                $_SESSION['error'] = 'Registration failed: ' . $e->getMessage();
                header("Location: /register");
                exit;
            }
        }


    }

    public function dashboard()
    {
        $this->view('/admin/dashboard');
    }

    // public function shop()
    // {
    //     if ($_SESSION['user']['role'] === 'user') {
    //         $this->view('/admin/dashboard');
    //     } else {
    //         $this->view('/user/shop');
    //     }
    // }
}
