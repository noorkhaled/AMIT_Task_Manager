<?php
namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $instance = null;

    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            $config = require __DIR__ . '/../../config/config.php';
            try {
                self::$instance = new PDO(
                    "mysql:host={$config['db_host']};dbname={$config['db_name']};charset=utf8mb4",
                    $config['db_user'],
                    $config['db_pass'],
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
            } catch (PDOException $e) {
                die("DB Connection failed: " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
