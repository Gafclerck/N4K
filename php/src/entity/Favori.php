<?php

namespace App\Entity;

class Favori
{
    private int $id;
    private int $user_id;
    private int $ressource_id;
    private string $created_at;

    private ?User $user = null;
    private ?Ressource $ressource = null;

    public function __construct() {}

    public function getId(): int
    {
        return $this->id;
    }
    public function getUserId(): int
    {
        return $this->user_id;
    }
    public function getRessourceId(): int
    {
        return $this->ressource_id;
    }
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }
    public function getUser(): ?User
    {
        return $this->user;
    }
    public function getRessource(): ?Ressource
    {
        return $this->ressource;
    }

    public function setUserId(int $id): void
    {
        $this->user_id = $id;
    }
    public function setRessourceId(int $id): void
    {
        $this->ressource_id = $id;
    }
    public function setUser(?User $u): void
    {
        $this->user = $u;
    }
    public function setRessource(?Ressource $r): void
    {
        $this->ressource = $r;
    }

    public function toDbArray(): array
    {
        return [
            "user_id" => $this->user_id,
            "ressource_id" => $this->ressource_id,
        ];
    }
}
