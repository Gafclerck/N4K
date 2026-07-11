<?php

namespace App\controllers;

use App\config\Request;
use App\controllers\AbstractController;
use App\services\FavoriService;
use App\services\RessourceService;
use App\services\GroupeService;

class UserController extends AbstractController
{
    private RessourceService $ressourceService;
    private FavoriService $favoriService;
    private GroupeService $groupeService;
    private static ?UserController $instance = null;
    private function __construct()
    {
        parent::__construct();
        $this->ressourceService = new RessourceService();
        $this->favoriService = new FavoriService();
        $this->groupeService = new GroupeService();
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
        $resources = $this->ressourceService->hydrateRessources($this->ressourceService->getPublicRessources());
        $recentResources = array_slice($resources, 0, 8);
        $allMatieres = $this->ressourceService->getAllMatieres();

        $myGroups = $this->groupeService->getGroupesByCurrentUser();

        $activeGroupId = $_GET['group'] ?? null;
        if ($activeGroupId) $activeGroupId = (int)$activeGroupId;
        $filterSubject = $_GET['subject'] ?? '';
        $filterType = $_GET['type'] ?? '';
        $search = $_GET['q'] ?? '';

        $q = strtolower($search);
        $feedResources = array_values(array_filter($resources, function ($r) use ($activeGroupId, $filterSubject, $filterType, $q) {
            if ($activeGroupId && $r->getGroupeId() !== $activeGroupId) return false;
            if ($filterSubject && $r->getMatiere()?->getNom() !== $filterSubject) return false;
            if ($filterType && $r->getType()->value !== $filterType) return false;
            if ($q && !str_contains(strtolower($r->getTitre()), $q)) return false;
            return true;
        }));

        $this->render('index', [
            'resources' => $resources,
            'recentResources' => $recentResources,
            'allMatieres' => $allMatieres,
            'myGroups' => $myGroups,
            'activeGroupId' => $activeGroupId,
            'filterSubject' => $filterSubject,
            'filterType' => $filterType,
            'search' => $search,
            'feedResources' => $feedResources,
            'page' => 'index',
            'pageTitle' => 'Accueil - N4K',
        ]);
    }

    public function favoris()
    {
        $favoris = $this->favoriService->getFavoris();
        // mark all as favori since they come from the favoris list
        foreach ($favoris as $f) {
            if ($r = $f->getRessource()) {
                $r->setIsFavori(true);
            }
        }
        $this->render("favoris", [
            'favoris' => $favoris,
            'page' => 'favoris',
            'pageTitle' => 'Mes Favoris — N4K',
        ]);
    }

    public function toggleFavori(): void
    {
        if (Request::isPost()) {
            $ressourceId = (int)Request::post('ressource_id');
            $this->favoriService->toggle($ressourceId);
        }
        $referer = $_SERVER['HTTP_REFERER'] ?? '/';
        $this->redirect($referer);
    }
}
