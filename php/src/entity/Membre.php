<?php

namespace App\Entity;

use App\Entity\TypeMembre;
use DateTime;

class Membre
{
    private int $id;
    private int $groupe_id;
    private int $user_id;
    private string $integreted_at;
    private TypeMembre|string $role;
    // ATTRIBUTS METIERS
    private Groupe $groupe;
    private User $user;

    //CONSTRUCTEUR
    public function __construct() {}

    // GETTERS
    public function getDateIntegration()
    {
        return $this->integreted_at;
    }
    public function getGroupeId(): int
    {
        return $this->groupe_id;
    }
    public function getUserId(): int
    {
        return $this->user_id;
    }
    public function getGroupe(): Groupe
    {
        return $this->groupe;
    }
    public function getUser(): User
    {
        return $this->user;
    }
    public function getRole(): TypeMembre
    {
        if (is_string($this->role)) return TypeMembre::from($this->role);
        return $this->role;
    }

    // SETTERS
    public function  setGroupeId(int $groupe_id)
    {
        $this->groupe_id = $groupe_id;
    }
    public function setUserId(int $user_id)
    {
        $this->user_id = $user_id;
    }
    public function setTypeMembre(TypeMembre $role)
    {
        $this->role = $role;
    }
    public function  setGroupe(Groupe $groupe)
    {
        $this->groupe = $groupe;
    }
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function toDbArray(): array
    {
        return [
            "groupe_id" => $this->groupe_id,
            "user_id" => $this->user_id,
            "role" => $this->role instanceof TypeMembre ? $this->role->value : $this->role,
        ];
    }
}
