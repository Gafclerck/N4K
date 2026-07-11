<?php

namespace App\repository;

class CommentaireRepo extends AbstractRepo
{
    public function __construct()
    {
        parent::__construct();
        $this->tableName = "commentaires";
        $this->className = "App\\Entity\\Commentaire";
    }

    public function getByRessource(int $ressourceId): array
    {
        $pdo = $this->db->getConnection();
        $sql = "SELECT c.*, u.nom as user_nom FROM commentaires c
                JOIN users u ON u.id = c.user_id
                WHERE c.ressource_id = :ressource_id
                ORDER BY c.created_at ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['ressource_id' => $ressourceId]);
        $comments = $stmt->fetchAll(\PDO::FETCH_CLASS, $this->className);

        $userIds = array_unique(array_map(fn($c) => $c->getUserId(), $comments));
        if (!empty($userIds)) {
            $placeholders = implode(',', array_fill(0, count($userIds), '?'));
            $userStmt = $pdo->prepare("SELECT * FROM users WHERE id IN ($placeholders)");
            $userStmt->execute(array_values($userIds));
            $users = $userStmt->fetchAll(\PDO::FETCH_CLASS, "App\\Entity\\User");
            $userMap = [];
            foreach ($users as $u) {
                $userMap[$u->getId()] = $u;
            }
            foreach ($comments as $c) {
                if (isset($userMap[$c->getUserId()])) {
                    $c->setUser($userMap[$c->getUserId()]);
                }
            }
        }

        return $comments;
    }

    public function countByRessource(int $ressourceId): int
    {
        $pdo = $this->db->getConnection();
        $sql = "SELECT COUNT(*) FROM {$this->tableName} WHERE ressource_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $ressourceId]);
        return (int)$stmt->fetchColumn();
    }
}
