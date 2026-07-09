<?php

namespace App\Config;

class Database
{
    private static ?\PDO $pdo = null;

    private function __construct() {}
    public static function getInstance()
    {
        return new self();
    }
    public function getConnection(): \PDO
    {
        if (self::$pdo === null) {
            try {
                $dns = sprintf("mysql:host=%s;dbname=%s", DB_HOST, DB_NAME);
                self::$pdo = new \PDO($dns, DB_USER, DB_PASS);
            } catch (\Exception $e) {
                echo "Erreur de connection : ";
                echo $e->getMessage();
            }
        }
        return self::$pdo;
    }

    public function closeConnection()
    {
        self::$pdo = null;
    }
}
