<?php

namespace App\Entity;

class User
{
    private int $id;
    private string $nom;
    private string $username;
    private string $email;
    private string $password;
    private string $role;
    private string $created_at;

    public function __construct() {}

    public static function create(string $nom, string $username, string $email, string $password): User
    {
        $user = new User();
        $user->setNom($nom);
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setRole('User');
        return $user;
    }

    // GETTERS
    public function getId(): int
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    // SETTERS

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }
    public function setRole(string $role): void
    {
        $this->role = $role;
    }
    public function toDbArray(): array
    {
        return [
            "nom" => $this->nom,
            "username" => $this->username,
            "email" => $this->email,
            "password" => $this->password,
            "role" => $this->role,
        ];
    }
}
