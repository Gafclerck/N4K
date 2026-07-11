<?php

namespace App\Entity;

use DateTime;

class Commentaire
{
    private int $id;
    private string $message;
    private int $ressource_id;
    private int $user_id;
    private string $created_at;

    private ?User $user = null;

    public function __construct() {}

    public function create(string $message, int $ressource_id, int $user_id): void
    {
        $this->message = $message;
        $this->ressource_id = $ressource_id;
        $this->user_id = $user_id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getRessourceId(): int
    {
        return $this->ressource_id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function setRessourceId(int $id): void
    {
        $this->ressource_id = $id;
    }

    public function setUserId(int $id): void
    {
        $this->user_id = $id;
    }

    public function setUser(?User $user): void
    {
        $this->user = $user;
    }

    public function toDbArray(): array
    {
        return [
            "message" => $this->message,
            "ressource_id" => $this->ressource_id,
            "user_id" => $this->user_id
        ];
    }
}
