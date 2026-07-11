<?php

namespace App\services;

use App\Config\Session;
use App\Entity\Favori;
use App\repository\FavoriRepo;
use App\repository\RessourceRepo;

class FavoriService
{
    private FavoriRepo $favoriRepo;
    private RessourceRepo $ressourceRepo;

    public function __construct()
    {
        $this->favoriRepo = new FavoriRepo();
        $this->ressourceRepo = new RessourceRepo();
    }

    public function toggle(int $ressourceId): array
    {
        $user = Session::getCurrentUser();
        if (!$user) {
            return ['success' => false, 'error' => 'Connectez-vous.'];
        }

        $ressource = $this->ressourceRepo->selectById($ressourceId);
        if (!$ressource) {
            return ['success' => false, 'error' => 'Ressource introuvable.'];
        }

        if ($this->favoriRepo->isFavori($user->getId(), $ressourceId)) {
            $this->favoriRepo->remove($user->getId(), $ressourceId);
            return ['success' => true, 'action' => 'removed'];
        }

        $favori = new Favori();
        $favori->setUserId($user->getId());
        $favori->setRessourceId($ressourceId);
        $this->favoriRepo->insert($favori);
        return ['success' => true, 'action' => 'added'];
    }

    public function getFavoris(): array
    {
        $user = Session::getCurrentUser();
        if (!$user) return [];
        return $this->favoriRepo->getByUser($user->getId());
    }

    public function getFavoriIds(): array
    {
        $user = Session::getCurrentUser();
        if (!$user) return [];
        return $this->favoriRepo->getFavoriIdsByUser($user->getId());
    }
}
