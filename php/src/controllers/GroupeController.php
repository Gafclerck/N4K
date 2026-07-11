<?php

namespace App\controllers;

use App\config\Request;
use App\Config\Session;
use App\Config\Validator;
use App\controllers\AbstractController;
use App\Entity\Groupe;
use App\Entity\User;
use App\repository\MembreRepo;
use App\repository\GroupeRepo;
use App\services\GroupeService;
use App\services\RessourceService;

class GroupeController extends AbstractController
{
    private GroupeService $groupeService;
    private RessourceService $ressourceService;
    private static ?GroupeController $instance = null;
    private function __construct()
    {
        parent::__construct();
        $this->groupeService = new GroupeService();
        $this->ressourceService = new RessourceService();
    }

    public static function getInstance(): GroupeController
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function joinGroupe()
    {
        if (Request::isPost()) {
            $groupId = (int)Request::post('group_id');
            $code = Request::post('access_code');
            $result = $this->groupeService->joinGroup(
                $groupId,
                $code,
                Session::getCurrentUser()->getId()
            );
            if ($result['success']) {
                $this->redirect('/groupes');
                exit;
            }

            $groupes = $this->groupeService->getAllGroupes() ?? [];
            $joinGroup = null;
            foreach ($groupes as $g) {
                if ((int)$g->getId() === $groupId) {
                    $joinGroup = $g;
                    break;
                }
            }

            $this->render('groupes', [
                'groupes' => $groupes,
                'joinGroup' => $joinGroup,
                'joinErrors' => [$result['error']],
                'page' => 'groupes',
                'pageTitle' => 'Groupes - N4K',
            ]);
            exit;
        }

        $this->redirect('/groupes');
    }
    public function voirsGroupes()
    {
        if (Request::isGet()) {
            // ici on récupère tous les groupes et on les filtre selon les paramètres de la requête
            // je doit aussi hydrater les groupes pour avoir les informations complètes pour les views
            $groupes = $this->groupeService->hydrateGroupes($this->groupeService->getAllGroupes());

            $filter = $_GET['filter'] ?? 'all';
            $search = $_GET['q'] ?? '';
            $q = strtolower($search);
            $filtered = array_values(array_filter($groupes, function ($g) use ($filter, $q) {
                $matchType = $filter === 'all' || $g->getVisibilite() === $filter;
                $matchQ = $q ? str_contains(strtolower($g->getNom()), $q) : true;
                return $matchType && $matchQ;
            }));

            $showCreateModal = ($_GET['modal'] ?? '') === 'create';
            $joinGroup = null;
            $joinErrors = [];
            $joinId = $_GET['join'] ?? null;
            if ($joinId) {
                foreach ($groupes as $g) {
                    if ($g->getId() === (int)$joinId && !$g->isMember()) {
                        $joinGroup = $g;
                        break;
                    }
                }
            }

            $this->render('groupes', [
                "groupes" => $groupes,
                "filtered" => $filtered,
                "filter" => $filter,
                "search" => $search,
                "showCreateModal" => $showCreateModal, // pour afficher le modal de création si nécessaire
                "joinGroup" => $joinGroup,
                "joinErrors" => $joinErrors,
                "page" => "groupes",
                "pageTitle" => "Groupes - N4K",
            ]);
        }
    }
    public function voirGroupe(int $id)
    {
        $groupe = $this->groupeService->getGroupeById($id);
        if (!$groupe) {
            $this->pageNotFound();
            return;
        }
        $membreRepo = new MembreRepo();
        $isMember = $membreRepo->selectByGroupeUser(Session::getCurrentUser()->getId(), $id) !== null;
        $groupe->setIsMember($isMember);
        $groupe->setNbrMembres((new GroupeRepo())->countMembers($id));

        $ressources = $this->ressourceService->hydrateRessources($this->ressourceService->getRessourcesByGroup($id));
        $this->render('groupe', [
            'groupe' => $groupe,
            'ressources' => $ressources,
            'page' => 'groupes',
            'pageTitle' => htmlspecialchars($groupe->getNom()) . ' - N4K',
        ]);
    }

    public function formPublierDansGroupe(int $id)
    {
        $groupe = $this->groupeService->getGroupeById($id);
        if (!$groupe) {
            $this->pageNotFound();
            return;
        }
        $this->render('publier', [
            'showVisibility' => true,
            'groupId' => $id,
            'formAction' => '/groupe/' . $id . '/publier',
            'page' => 'publier',
            'pageTitle' => 'Publier - N4K',
        ]);
    }

    public function createGroupe()
    {
        if (Request::isPost()) {
            $validator = new Validator();
            $validator->validate([
                "nom" => ["vide"],
                "description" => ["vide"],
                "type" => ["type"]
            ], Request::post());
            if ($validator->noErrors()) {
                $nom = Request::post('nom');
                $description = Request::post('description');
                $visibilite = Request::post('type');
                $groupe = new Groupe();
                $groupe->setNom($nom);
                $groupe->setDescription($description);
                $groupe->setVisibilite($visibilite);
                if ($this->groupeService->addGroupe($groupe)) {
                    $this->redirect("/groupes");
                    exit;
                }
            }
            $this->render('/groupes', [
                "errors" => $validator->getErrors(),
                "olds" => $validator->getOldValues(Request::post()),
                "showCreateModal" => "create",
                "page" => "groupes",
                "pageTitle" => "Groupes N4K",
            ]);
        } else {
            $this->render('groupes', [
                "page" => "groupes",
                "pageTitle" => "Groupes N4K",
            ]);
        }
    }
}
