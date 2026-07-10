<?php

namespace App\controllers;

use App\Config\Session;
use App\Config\Validator;
use App\controllers\AbstractController;
use App\services\RessourceService;

class RessourceController extends AbstractController
{
    private RessourceService $ressourceService;
    private static ?RessourceController $instance = null;
    private function __construct()
    {
        parent::__construct();
        $this->ressourceService = new RessourceService();
    }

    public static function getInstance(): RessourceController
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function publier(): void
    {
        if ($this->request->isPost()) {
            Validator::validate([
                "title" => ["vide"],
                "description" => ["vide"],
                "type" => ["vide"],
            ], $this->request->post());

            if (Validator::noErrors()) {
                $file = $_FILES['file'] ?? null;
                $result = $this->ressourceService->createRessource($this->request->post(), $file);
                if ($result['success']) {
                    $this->redirect('/mes-ressources');
                    exit;
                }
                $errors = array_merge(Validator::getErrors(), $result['errors']);
            } else {
                $errors = Validator::getErrors();
            }

            $matieres = $this->ressourceService->getAllMatieres();
            $this->render('publier', [
                "errors" => $errors ?? Validator::getErrors(),
                "olds" => Validator::getOldValues($this->request->post()),
                "matieres" => $matieres,
            ]);
            return;
        }

        $matieres = $this->ressourceService->getAllMatieres();
        $this->render('publier', ["matieres" => $matieres]);
    }

    public function publierDansGroupe(int $id): void
    {
        if (!Session::isConnected()) {
            $this->redirect('/login');
            return;
        }

        if ($this->request->isPost()) {
            Validator::validate([
                "title" => ["vide"],
                "description" => ["vide"],
                "type" => ["vide"],
            ], $this->request->post());

            if (Validator::noErrors()) {
                $data = $this->request->post();
                $data['group_id'] = $id;
                $file = $_FILES['file'] ?? null;
                $result = $this->ressourceService->createRessource($data, $file);
                if ($result['success']) {
                    $this->redirect('/groupe/' . $id);
                    exit;
                }
                $errors = array_merge(Validator::getErrors(), $result['errors']);
            } else {
                $errors = Validator::getErrors();
            }

            $matieres = $this->ressourceService->getAllMatieres();
            $this->render('publier', [
                "errors" => $errors ?? Validator::getErrors(),
                "olds" => Validator::getOldValues($this->request->post()),
                "showVisibility" => true,
                "groupId" => $id,
                "formAction" => '/groupe/' . $id . '/publier',
                "matieres" => $matieres,
            ]);
            return;
        }

        $matieres = $this->ressourceService->getAllMatieres();
        $this->render('publier', [
            "showVisibility" => true,
            "groupId" => $id,
            "formAction" => '/groupe/' . $id . '/publier',
            "matieres" => $matieres,
        ]);
    }

    public function download(int $id): void
    {
        $ressource = $this->ressourceService->getRessourceById($id);
        if (!$ressource || !$ressource->getFilepath()) {
            $this->pageNotFound();
            return;
        }

        $file = dirname(__DIR__, 2) . '/src/public/' . $ressource->getFilepath();
        if (!file_exists($file)) {
            $this->pageNotFound();
            return;
        }

        header('Content-Type: ' . ($ressource->getMimeType() ?? 'application/octet-stream'));
        header('Content-Disposition: attachment; filename="' . ($ressource->getOriginalName() ?? basename($file)) . '"');
        header('Content-Length: ' . $ressource->getFileSize());
        readfile($file);
        exit;
    }

    public function view(int $id): void
    {
        $ressource = $this->ressourceService->getRessourceById($id);
        if (!$ressource || !$ressource->getFilepath()) {
            $this->pageNotFound();
            return;
        }

        $file = dirname(__DIR__, 2) . '/src/public/' . $ressource->getFilepath();
        if (!file_exists($file)) {
            $this->pageNotFound();
            return;
        }

        header('Content-Type: ' . ($ressource->getMimeType() ?? 'application/octet-stream'));
        header('Content-Disposition: inline; filename="' . ($ressource->getOriginalName() ?? basename($file)) . '"');
        header('Content-Length: ' . $ressource->getFileSize());
        readfile($file);
        exit;
    }

    public function voirRessourcesByGroup(int $id): void
    {
        $ressources = $this->ressourceService->getRessourcesByGroup($id);
        $this->render('ressources-groupe', [
            'ressources' => $ressources,
            'groupeId' => $id,
        ]);
    }

    public function voirMesRessources(): void
    {
        if (!Session::isConnected()) {
            $this->redirect('/login');
            return;
        }
        $ressources = $this->ressourceService->getRessourcesByCurrentUser();
        $this->render('mes-ressources', ['ressources' => $ressources]);
    }
}
