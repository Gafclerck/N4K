<?php

namespace App\repository;

class MatiereRepo extends AbstractRepo
{
    public function __construct()
    {
        parent::__construct();
        $this->tableName = "matieres";
        $this->className = "App\\entity\\Matiere";
    }
}
