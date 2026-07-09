<?php

namespace App\entity;

use \DateTimeImmutable;
use App\Entity\Matiere;
use App\entity\Visibilite;
use App\entity\TypeRessource;
use DateTime;

class Ressource
{
    private String $titre;
    private String $description;
    private string $created_at;
    private string|TypeRessource $type;
    private string|Visibilite $visibilite;
    private int $matiere_id;
    private int $groupe_id;
    private int $auteur_id;

    private Matiere $matiere;
    private Groupe $groupe;
    private User $auteur;

    private int $views = 0;
    private int $downloads = 0;
    private bool $pinned = false;
    private array $comments = [];

    public function __construct() {}

    // Getters
    public function getTitre(): string
    {
        return $this->titre;
    }
    public function getDescription(): String
    {
        return $this->description;
    }
    public function getDatePartage(): DateTime
    {
        return DateTime::createFromFormat("jj/mm/aaaa", $this->created_at);
    }
    public function getMatiere(): Matiere
    {
        return $this->matiere;
    }
    public function getType(): TypeRessource
    {
        if (is_string($this->type)) return TypeRessource::from($this->type);
        return $this->type;
    }
    public function getVisibilite(): Visibilite
    {
        if (is_string($this->visibilite)) return Visibilite::from($this->visibilite);
        return $this->visibilite;
    }
    public function getGroupeId(): int
    {
        return $this->groupe_id;
    }
    public function getAuteurId(): int
    {
        return $this->auteur_id;
    }
    public function getGroupe(): Groupe
    {
        return $this->groupe;
    }
    public function getAuteur(): User
    {
        return $this->auteur;
    }
    public function getViews(): int
    {
        return $this->views;
    }
    public function getDownloads(): int
    {
        return $this->downloads;
    }
    public function isPinned(): bool
    {
        return $this->pinned;
    }
    public function getComments(): array
    {
        return $this->comments;
    }
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    // Setters
    public function setTitre(String $titre)
    {
        $this->titre = $titre;
    }
    public function setDescription(String $description)
    {
        $this->description = $description;
    }
    public function setMatiere(Matiere $matiere)
    {
        $this->matiere = $matiere;
    }
    public function setMatiereId(int $matiere_id)
    {
        $this->matiere_id = $matiere_id;
    }
    public function setType(TypeRessource $type)
    {
        $this->type = $type;
    }
    public function setVisibilite(Visibilite $visibilite)
    {
        $this->visibilite = $visibilite;
    }
    public function setGroupe(Groupe $groupe)
    {
        $this->groupe = $groupe;
    }
    public function setAuteur(User $auteur)
    {
        $this->auteur = $auteur;
    }
    public function setGroupeId(int $groupe_id): void
    {
        $this->groupe_id = $groupe_id;
    }
    public function setAuteurId(int $auteur_id): void
    {
        $this->auteur_id = $auteur_id;
    }
    public function setViews(int $views): void
    {
        $this->views = $views;
    }
    public function setDownloads(int $downloads): void
    {
        $this->downloads = $downloads;
    }
    public function setPinned(bool $pinned): void
    {
        $this->pinned = $pinned;
    }
    public function setComments(array $comments): void
    {
        $this->comments = $comments;
    }
    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = $created_at;
    }

    // METHODES ADDITIONNELS
    // groupe 0 correspond au public
    public static function create(
        String $titre,
        String $description,
        int $matiere_id,
        TypeRessource $type_ressource,
        int $auteur_id,
        int $groupe_id = 0
    ) {
        $ressource = new Ressource();
        $ressource->setTitre($titre);
        $ressource->setDescription($description);
        $ressource->setMatiereId($matiere_id);
        $ressource->setType($type_ressource);
        $ressource->setAuteurId($auteur_id);
        $ressource->setGroupeId($groupe_id);
        return $ressource;
    }

    public function toDbArray(): array
    {
        return [
            "titre" => $this->titre,
            "description" => $this->description,
            "type" => $this->getType()->value,
            "visibilite" => $this->getVisibilite()->value,
            "matiere_id" => $this->matiere_id,
            "groupe_id" => $this->groupe_id,
            "auteur_id" => $this->auteur_id
        ];
    }
}
