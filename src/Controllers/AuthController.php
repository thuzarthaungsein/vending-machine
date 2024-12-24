<?php

namespace App\Controllers;

use App\Config\Database;
use App\Models\User;
use PDOException;

class AuthController extends BaseController
{
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
        $status = User::login($username, $password);
        if ($status) {
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
                $check = User::checkUnique($username);
                if (!$check) {
                    $_SESSION['error'] = "Username already exists!";
                    header("Location: /register");
                    exit;
                }

                User::register($username, $password, $role);

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

}
