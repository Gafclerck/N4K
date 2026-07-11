<?php

namespace App\Entity;

class Matiere
{
    private int $id;
    private String $nom;
    private String $description;

    public function __construct() {}

    public function create(String $nom, String $description): Matiere
    {
        $mat = new Matiere();
        $mat->setNom($nom);
        $mat->setDescription($description);
        return $mat;
    }

    // Getters
    public function getId(): int
    {
        return $this->id;
    }
    public function getNom()
    {
        return $this->nom;
    }
    public function getDescription()
    {
        return $this->description;
    }

    // Setters
    public function setNom(string $nom)
    {
        $this->nom = $nom;
    }
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    //methodes complementaires
    public function toDbArray(): array
    {
        return [
            "nom" => $this->nom,
            "description" => $this->description,
        ];
    }
}
