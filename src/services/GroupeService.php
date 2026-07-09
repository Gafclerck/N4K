<?php

namespace App\services;

use App\config\Session;
use App\Entity\Groupe;
use App\entity\TypeMembre;
use App\repository\GroupeRepo;
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

    public function getGroupesByCurrentUser(): array
    {
        $user = Session::getCurrentUser();
        if (!$user) return [];
        return $this->groupeRepo->selectGroupesByUser($user->getId());
    }
}
