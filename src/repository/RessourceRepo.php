<?php

namespace App\repository;

class RessourceRepo extends AbstractRepo
{
    public function __construct()
    {
        parent::__construct();
        $this->tableName = "ressources";
        $this->className = "App\\Entity\\Ressource";
    }
}
