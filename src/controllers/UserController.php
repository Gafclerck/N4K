<?php

namespace App\controllers;

use App\controllers\AbstractController;
use App\services\RessourceService;

class UserController extends AbstractController
{
    private RessourceService $ressourceService;
    private static ?UserController $instance = null;
    private function __construct()
    {
        parent::__construct();
        $this->ressourceService = new RessourceService();
    }

    public static function getInstance(): UserController
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function index()
    {
        $resources = $this->ressourceService->getPublicRessources();
        $recentResources = array_slice($resources, 0, 8);
        $allMatieres = $this->ressourceService->getAllMatieres();
        $this->render('index', [
            'resources' => $resources,
            'recentResources' => $recentResources,
            'allMatieres' => $allMatieres,
        ]);
    }

    public function favoris()
    {
        $this->render("favoris");
    }
}
