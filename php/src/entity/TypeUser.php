<?php

namespace App\Entity;

enum TypeUser: string
{
    case ADMIN = "Admin";
    case USER = "User";
}
