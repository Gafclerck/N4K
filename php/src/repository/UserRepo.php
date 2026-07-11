<?php

namespace App\repository;

class UserRepo extends AbstractRepo
{
    public function __construct()
    {
        parent::__construct();
        $this->tableName = "users";
        $this->className = "App\\Entity\\User";
    }

    public function selectByUsername(string $username): ?object
    {
        $pdo = $this->db->getConnection();
        $sql = "SELECT * FROM {$this->tableName} WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username' => $username]);
        $result = $stmt->fetchObject($this->className);
        return $result === false ? null : $result;
    }
}
