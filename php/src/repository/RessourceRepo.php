<?php

namespace App\repository;

class RessourceRepo extends AbstractRepo
{
    public function __construct()
    {
        parent::__construct();
        $this->tableName = "ressources";
        $this->className = "App\\Entity\\Ressource";
    }

    public function getRessourceByGroup(int $groupeId): array
    {
        $pdo = $this->db->getConnection();
        $sql = "SELECT * FROM {$this->tableName} WHERE groupe_id = :groupe_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['groupe_id' => $groupeId]);
        $result = $stmt->fetchAll(\PDO::FETCH_CLASS, $this->className);
        return $result;
    }

    public function getRessourceByUser(int $userId): array
    {
        $pdo = $this->db->getConnection();
        $sql = "SELECT * FROM {$this->tableName} WHERE auteur_id = :auteur_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['auteur_id' => $userId]);
        $result = $stmt->fetchAll(\PDO::FETCH_CLASS, $this->className);
        return $result;
    }

    public function getPublicRessources(): array
    {
        $pdo = $this->db->getConnection();
        $sql = "SELECT * FROM {$this->tableName} WHERE groupe_id = 0";
        $stmt = $pdo->query($sql);
        $result = $stmt->fetchAll(\PDO::FETCH_CLASS, $this->className);
        return $result;
    }
}
