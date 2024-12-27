<?php

namespace App\Config;

use Dotenv\Dotenv;
use PDO;
use PDOException;

require_once __DIR__ . '/../../vendor/autoload.php';

class Database
{
    private static $conn = null;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable('/var/www/html/');
        $dotenv->load();
        $this->connect();
    }

    // this is a connection class to manage database connection
    // to be cleaned and structured, other CRUD operations for products, users and transactions will be created as separate classes in "/models"

    public function connect()
    {
        self::$conn = null;
        if (self::$conn === null) {
            try {
                self::$conn = new PDO(
                    "mysql:host=".$_ENV['DB_HOST'].";dbname=" .$_ENV['DB_NAME'],
                    $_ENV['DB_USER'],
                    $_ENV['DB_PASSWORD']
                );
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Connection error: " . $e->getMessage();
            }
        }

        return self::$conn;
    }

}
