<?php

namespace App\controllers;

use App\Config\Session;
use App\Config\Validator;
use App\controllers\AbstractController;
use App\entity\Groupe;
use App\entity\User;
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
        if ($this->request->isPost()) {
            $groupId = (int)$this->request->post('group_id');
            $code = $this->request->post('access_code');
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
            ]);
            exit;
        }

        $this->redirect('/groupes');
    }
    public function voirsGroupes()
    {
        if ($this->request->isGet()) {
            $groupes = $this->groupeService->getAllGroupes();
            $this->render('groupes', ["groupes" => $groupes]);
        }
    }
    public function voirGroupe(int $id)
    {
        $groupe = $this->groupeService->getGroupeById($id);
        if (!$groupe) {
            $this->pageNotFound();
            return;
        }
        $ressources = $this->ressourceService->getRessourcesByGroup($id);
        $this->render('groupe', [
            'groupe' => $groupe,
            'ressources' => $ressources,
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
        ]);
    }

    public function createGroupe()
    {
        if ($this->request->isPost()) {
            Validator::validate([
                "nom" => ["vide"],
                "description" => ["vide"],
                "type" => ["type"]
            ], $this->request->post());
            if (Validator::noErrors()) {
                $nom = $this->request->post('nom');
                $description = $this->request->post('description');
                $visibilite = $this->request->post('type');
                $groupe = new Groupe();
                $groupe->setNom($nom);
                $groupe->setDescription($description);
                $groupe->setVisibilite($visibilite);
                if ($this->groupeService->addGroupe($groupe)) {
                    $this->redirect("/groupes");
                    exit;
                }
            }
            $this->render('/groupes', ["errors" => Validator::getErrors(), "olds" => Validator::getOldValues($this->request->post()), "showCreateModal" => "create"]);
        } else {
            $this->render('groupes');
        }
    }
}
