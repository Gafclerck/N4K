<?php

namespace App\services;

use App\Entity\User;
use App\repository\UserRepo;

class UserService
{
    private UserRepo $userRepo;
    public function __construct()
    {
        $this->userRepo = new UserRepo();
    }

    public function registerUser(User $user): bool
    {
        return $this->userRepo->insert($user) > 0;
    }

    public function authenticateUser(string $username, string $password): ?User
    {
        $user = $this->userRepo->selectByUsername($username);
        if ($user !== null && password_verify($password, $user->getPassword())) {
            return $user;
        }
        return null;
    }
}
