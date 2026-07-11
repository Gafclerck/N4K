<?php

namespace App\services;

use App\Entity\Commentaire;
use App\repository\CommentaireRepo;

class CommentaireService
{
    private CommentaireRepo $commentaireRepo;

    public function __construct()
    {
        $this->commentaireRepo = new CommentaireRepo();
    }

    public function addComment(string $message, int $ressourceId, int $userId): bool
    {
        $commentaire = new Commentaire();
        $commentaire->setMessage($message);
        $commentaire->setRessourceId($ressourceId);
        $commentaire->setUserId($userId);
        return $this->commentaireRepo->insert($commentaire) > 0;
    }

    public function getCommentsByRessource(int $ressourceId): array
    {
        return $this->commentaireRepo->getByRessource($ressourceId);
    }

    public function countByRessource(int $ressourceId): int
    {
        return $this->commentaireRepo->countByRessource($ressourceId);
    }
}
