<?php

namespace App\controllers;

use App\Config\Session;
use App\Config\Validator;
use App\controllers\AbstractController;
use App\entity\Groupe;
use App\entity\User;
use App\services\GroupeService;

class GroupeController extends AbstractController
{
    private GroupeService $groupeService;
    private static ?GroupeController $instance = null;
    private function __construct()
    {
        parent::__construct();
        $this->groupeService = new GroupeService();
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
