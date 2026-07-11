<?php

namespace App\repository;

class FavoriRepo extends AbstractRepo
{
    public function __construct()
    {
        parent::__construct();
        $this->tableName = "favoris";
        $this->className = "App\\Entity\\Favori";
    }

    public function getByUser(int $userId): array
    {
        $pdo = $this->db->getConnection();
        $sql = "SELECT f.*, r.* FROM favoris f
                JOIN ressources r ON r.id = f.ressource_id
                WHERE f.user_id = :user_id
                ORDER BY f.created_at DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        $favoris = $stmt->fetchAll(\PDO::FETCH_CLASS, $this->className);

        $ressourceIds = array_unique(array_map(fn($f) => $f->getRessourceId(), $favoris));
        if (!empty($ressourceIds)) {
            $placeholders = implode(',', array_fill(0, count($ressourceIds), '?'));
            $resStmt = $pdo->prepare("SELECT * FROM ressources WHERE id IN ($placeholders)");
            $resStmt->execute(array_values($ressourceIds));
            $ressources = $resStmt->fetchAll(\PDO::FETCH_CLASS, "App\\Entity\\Ressource");
            $resMap = [];
            foreach ($ressources as $r) {
                $resMap[$r->getId()] = $r;
            }
            foreach ($favoris as $f) {
                if (isset($resMap[$f->getRessourceId()])) {
                    $f->setRessource($resMap[$f->getRessourceId()]);
                }
            }
        }

        return $favoris;
    }

    public function getFavoriIdsByUser(int $userId): array
    {
        $pdo = $this->db->getConnection();
        $sql = "SELECT ressource_id FROM {$this->tableName} WHERE user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function isFavori(int $userId, int $ressourceId): bool
    {
        $pdo = $this->db->getConnection();
        $sql = "SELECT COUNT(*) FROM {$this->tableName} WHERE user_id = :user_id AND ressource_id = :ressource_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId, 'ressource_id' => $ressourceId]);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function remove(int $userId, int $ressourceId): bool
    {
        $pdo = $this->db->getConnection();
        $sql = "DELETE FROM {$this->tableName} WHERE user_id = :user_id AND ressource_id = :ressource_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId, 'ressource_id' => $ressourceId]);
        return $stmt->rowCount() > 0;
    }
}
