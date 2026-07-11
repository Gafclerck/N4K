<?php

namespace App\Config;

class Database
{
    private static ?Database $instance = null;
    private ?\PDO $pdo = null;

    private function __construct() {}

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): \PDO
    {
        if ($this->pdo === null) {
            try {
                $dns = sprintf("mysql:host=%s;dbname=%s", DB_HOST, DB_NAME);
                $this->pdo = new \PDO($dns, DB_USER, DB_PASS);
            } catch (\Exception $e) {
                echo "Erreur de connection : ";
                echo $e->getMessage();
            }
        }
        return $this->pdo;
    }

    public function closeConnection(): void
    {
        $this->pdo = null;
    }
}
