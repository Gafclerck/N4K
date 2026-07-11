<?php

namespace App\repository;

use App\Entity\Membre;

class MembreRepo extends AbstractRepo
{
    public function __construct()
    {
        parent::__construct();
        $this->tableName = "membres";
        $this->className = "App\\Entity\\Membre";
    }

    public function selectByGroupeUser(int $user_id, int $groupe_id): ?Membre
    {
        $pdo = $this->db->getConnection();
        $sql = "SELECT * FROM {$this->tableName} WHERE user_id = :user_id AND groupe_id = :groupe_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['user_id' => $user_id, "groupe_id" => $groupe_id]);
        $result = $stmt->fetchObject($this->className);
        return $result === false ? null : $result;
    }

    public function selectByUser(int $user_id): array
    {
        $pdo = $this->db->getConnection();
        $sql = "SELECT * FROM {$this->tableName} WHERE user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
        $result = $stmt->fetchAll(\PDO::FETCH_CLASS, $this->className);
        return $result;
    }
}
