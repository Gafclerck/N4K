<?php

namespace App\Entity;

use App\Entity\Visibilite;

use \DateTime;

class Groupe
{
    private int $id;
    private string $nom;
    private string $description;
    private string $code;
    private string $visibilite;
    private int $admin_id;
    private string $created_at;

    // ATTRIBUT DE RELATION
    private User $admin;

    //ATTRIBUT POUR LES VUES
    private ?int $nbrMembres = null;
    private ?bool $isMember = null;

    //constructeur
    public function __construct() {}
    // GETTERS
    public function getId(): int
    {
        return $this->id;
    }
    public function getNom(): string
    {
        return $this->nom;
    }
    public function getDescription(): string
    {
        return $this->description;
    }
    public function getDateCreation(): DateTime
    {
        return Datetime::createFromFormat("jj/mm/aaaa", $this->created_at);
    }
    public function getCode(): string
    {
        return $this->code;
    }
    public function getVisibilite(): string
    {
        // a gerer plus tard
        return $this->visibilite;
    }

    public function getAdmin(): User
    {
        return $this->admin;
    }
    public function getAdminId(): int
    {
        return $this->admin_id;
    }

    // SETTERS
    public function setId(int $id)
    {
        $this->id = $id;
    }
    public function setNom(string $nom)
    {
        $this->nom = $nom;
    }
    public function setDescription(string $description)
    {
        $this->description = $description;
    }
    public function setCode(string $code)
    {
        $this->code = $code;
    }
    public function setVisibilite(string $visibilite)
    {
        $this->visibilite = $visibilite;
    }
    public function setAdmin(User $user)
    {
        $this->admin = $user;
    }
    public function setAdminId(int $id): void
    {
        $this->admin_id = $id;
    }
    public function getNbrMembres(): ?int
    {
        return $this->nbrMembres;
    }
    public function setNbrMembres(?int $nbr): void
    {
        $this->nbrMembres = $nbr;
    }
    public function isMember(): ?bool
    {
        return $this->isMember;
    }
    public function setIsMember(?bool $val): void
    {
        $this->isMember = $val;
    }
    public function toDbArray()
    {
        return [
            "nom" => $this->nom,
            "description" => $this->description,
            "code" => $this->code,
            "visibilite" => $this->visibilite,
            "admin_id" => $this->admin_id
        ];
    }
}
