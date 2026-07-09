<?php

namespace App\repository;

use App\Entity\Groupe;
use App\entity\TypeMembre;

class GroupeRepo extends AbstractRepo
{
    public function __construct()
    {
        parent::__construct();
        $this->tableName = "groupes";
        $this->className = "App\\entity\\Groupe";
    }

    public function selectGroupesByUser(int $userId): array
    {
        $pdo = $this->db->getConnection();
        $sql = "SELECT g.* FROM {$this->tableName} g JOIN membres m ON g.id = m.groupe_id WHERE m.user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        $result = $stmt->fetchAll(\PDO::FETCH_CLASS, $this->className);
        $this->db->closeConnection();
        return $result;
    }

    public function insertWithCreator(Groupe $groupe, int $userId, TypeMembre $role): ?int
    {
        $pdo = $this->db->getConnection();
        try {
            $pdo->beginTransaction();
            $dbArray = $groupe->toDbArray();
            $keys = [];
            foreach ($dbArray as $key => $val) {
                $keys[] = $key;
            }
            $columns = "(" . implode(', ', $keys) . ")";
            $placeholders = "(:" . implode(', :', $keys) . ")";
            $stmt = $pdo->prepare("INSERT INTO {$this->tableName} {$columns} VALUES {$placeholders}");
            $stmt->execute($dbArray);
            $groupId = (int)$pdo->lastInsertId();

            $stmt = $pdo->prepare("INSERT INTO membres (groupe_id, user_id, role) VALUES (:groupe_id, :user_id, :role)");
            $stmt->execute([
                'groupe_id' => $groupId,
                'user_id' => $userId,
                'role' => $role->value,
            ]);

            $pdo->commit();
            $this->db->closeConnection();
            return $groupId;
        } catch (\Exception $e) {
            $pdo->rollBack();
            $this->db->closeConnection();
            return null;
        }
    }
}
