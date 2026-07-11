<?php

namespace App\controllers;

use App\config\Request;
use App\Config\Session;
use App\Config\Validator;
use App\controllers\AbstractController;
use App\services\CommentaireService;
use App\services\RessourceService;

class RessourceController extends AbstractController
{
    private RessourceService $ressourceService;
    private CommentaireService $commentaireService;
    private static ?RessourceController $instance = null;
    private function __construct()
    {
        parent::__construct();
        $this->ressourceService = new RessourceService();
        $this->commentaireService = new CommentaireService();
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
        if (Request::isPost()) {
            $validator = new Validator();
            $validator->validate([
                "title" => ["vide"],
                "description" => ["vide"],
                "type" => ["vide"],
            ], Request::post());

            if ($validator->noErrors()) {
                $file = $_FILES['file'] ?? null;
                $result = $this->ressourceService->createRessource(Request::post(), $file);
                if ($result['success']) {
                    $this->redirect('/mes-ressources');
                    exit;
                }
                $errors = array_merge($validator->getErrors(), $result['errors']);
            } else {
                $errors = $validator->getErrors();
            }

            $matieres = $this->ressourceService->getAllMatieres();
            $this->render('publier', [
                "errors" => $errors ?? $validator->getErrors(),
                "olds" => $validator->getOldValues(Request::post()),
                "matieres" => $matieres,
                "page" => "publier",
                "pageTitle" => "Publier — N4K",
            ]);
            return;
        }

        $matieres = $this->ressourceService->getAllMatieres();
        $this->render('publier', [
            "matieres" => $matieres,
            "page" => "publier",
            "pageTitle" => "Publier — N4K",
        ]);
    }

    public function publierDansGroupe(int $id): void
    {
        if (Request::isPost()) {
            $validator = new Validator();
            $validator->validate([
                "title" => ["vide"],
                "description" => ["vide"],
                "type" => ["vide"],
            ], Request::post());

            if ($validator->noErrors()) {
                $data = Request::post();
                $data['group_id'] = $id;
                $file = $_FILES['file'] ?? null;
                $result = $this->ressourceService->createRessource($data, $file);
                if ($result['success']) {
                    $this->redirect('/groupe/' . $id);
                    exit;
                }
                $errors = array_merge($validator->getErrors(), $result['errors']);
            } else {
                $errors = $validator->getErrors();
            }

            $matieres = $this->ressourceService->getAllMatieres();
            $this->render('publier', [
                "errors" => $errors ?? $validator->getErrors(),
                "olds" => $validator->getOldValues(Request::post()),
                "showVisibility" => true,
                "groupId" => $id,
                "formAction" => '/groupe/' . $id . '/publier',
                "matieres" => $matieres,
                "page" => "publier",
                "pageTitle" => "Publier — N4K",
            ]);
            return;
        }

        $matieres = $this->ressourceService->getAllMatieres();
        $this->render('publier', [
            "showVisibility" => true,
            "groupId" => $id,
            "formAction" => '/groupe/' . $id . '/publier',
            "matieres" => $matieres,
            "page" => "publier",
            "pageTitle" => "Publier — N4K",
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
        $ressources = $this->ressourceService->hydrateRessources($this->ressourceService->getRessourcesByGroup($id));
        $this->render('ressources-groupe', [
            'ressources' => $ressources,
            'groupeId' => $id,
            'page' => 'ressources-groupe',
            'pageTitle' => 'Ressources du groupe — N4K',
        ]);
    }

    public function detail(int $id): void
    {
        $ressource = $this->ressourceService->getRessourceById($id);
        if (!$ressource) {
            $this->pageNotFound();
            return;
        }
        $ressources = $this->ressourceService->hydrateRessources([$ressource]);
        $ressource = $ressources[0];
        $commentaires = $this->commentaireService->getCommentsByRessource($id);
        $this->render('ressource-detail', [
            'ressource' => $ressource,
            'commentaires' => $commentaires,
            'page' => 'ressource-detail',
            'pageTitle' => htmlspecialchars($ressource->getTitre()),
        ]);
    }

    public function commenter(int $id): void
    {
        if (Request::isPost()) {
            $message = Request::post('message');
            if (!empty(trim($message ?? ''))) {
                $this->commentaireService->addComment(
                    trim($message),
                    $id,
                    Session::getCurrentUser()->getId()
                );
            }
        }
        $this->redirect('/ressource/' . $id);
    }

    public function voirMesRessources(): void
    {
        $ressources = $this->ressourceService->hydrateRessources($this->ressourceService->getRessourcesByCurrentUser());

        $typeFilter = $_GET['type'] ?? '';
        $search = $_GET['q'] ?? '';
        $q = strtolower($search);
        $filtered = array_values(array_filter($ressources, function ($r) use ($typeFilter, $q) {
            if ($typeFilter && $r->getType()->value !== $typeFilter) return false;
            if ($q && !str_contains(strtolower($r->getTitre()), $q)) return false;
            return true;
        }));

        $this->render('mes-ressources', [
            'ressources' => $ressources,
            'filtered' => $filtered,
            'typeFilter' => $typeFilter,
            'search' => $search,
            'page' => 'mes-publications',
            'pageTitle' => 'Mes publications — N4K',
        ]);
    }
}
