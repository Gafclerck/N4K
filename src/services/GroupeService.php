<?php

namespace App\services;

use App\config\Session;
use App\Entity\Groupe;
use App\entity\Membre;
use App\entity\TypeMembre;
use App\repository\GroupeRepo;
use App\repository\MembreRepo;
use \DateTime;

class GroupeService
{
    private GroupeRepo $groupeRepo;
    public function __construct()
    {
        $this->groupeRepo = new GroupeRepo();
    }

    public function addGroupe(Groupe $groupe): ?int
    {
        $groupe->setCode($this->generateCode());
        $groupe->setAdminId(Session::getCurrentUser()->getId());
        return $this->groupeRepo->insertWithCreator(
            $groupe,
            Session::getCurrentUser()->getId(),
            TypeMembre::ADMIN
        );
    }

    private function generateCode(): string
    {
        return (string)(new DateTime())->getTimestamp() + random_int(111111, 999999);
    }

    public function getAllGroupes(): ?array
    {
        return $this->groupeRepo->selectAll();
    }

    public function getGroupeById(int $id): ?Groupe
    {
        return $this->groupeRepo->selectById($id);
    }

    public function getGroupesByCurrentUser(): array
    {
        $user = Session::getCurrentUser();
        if (!$user) return [];
        return $this->groupeRepo->selectGroupesByUser($user->getId());
    }

    public function joinGroup(int $groupId, string | null $code, int $userId): array
    {
        $groupe = $this->groupeRepo->selectById($groupId);
        if (!$groupe) {
            return ['success' => false, 'error' => 'Groupe introuvable.'];
        }

        if ($groupe->getVisibilite() === 'Prive' && $groupe->getCode() !== $code) {
            return ['success' => false, 'error' => "Code d'accès invalide."];
        }

        $membreRepo = new MembreRepo();
        $existing = $membreRepo->selectByGroupeUser($userId, $groupId);
        if ($existing) {
            return ['success' => false, 'error' => 'Vous êtes déjà membre de ce groupe.'];
        }

        $membre = new Membre();
        $membre->setGroupeId($groupId);
        $membre->setUserId($userId);
        $membre->setTypeMembre(TypeMembre::MEMBRE);
        $membreRepo->insert($membre);
        return ['success' => true];
    }
}
