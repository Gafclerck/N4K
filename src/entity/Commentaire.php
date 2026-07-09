<?php

namespace App\entity;
use App\Entity\Ressource;

use DateTime;

class Commentaire
{
    private int $id;
    private String $message;
    private int $ressource_id;
    private int $user_id;
    private String $created_at;

    //ATTRIBUT DE RELATION
    private $date;
    private User $user;

    public function __contruct() {}
    public function create(String $message, int $ressource_id, int $user_id)
    {
        $this->message = $message;
        $this->ressource_id = $ressource_id;
        $this->user_id = $user_id;
    }

    //GETTERS 
    public function getiD(): int
    {
        return $this->id;
    }
    public function getMessage(): String
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
    public function getDate(): DateTime
    {
        return DateTime::createFromFormat("jj/mm/aaaa",  $this->created_at);
    }

    // pour afficher le user qui a envoyer le commentaire
    public function getUser(): User
    {
        return $this->user;
    }

    // SETTERS
    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function setMessage(String $message): void
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
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function toDbArray()
    {
        return [
            "message" => $this->message,
            "ressource_id" => $this->ressource_id,
            "user_id" => $this->user_id
        ];
    }
}
