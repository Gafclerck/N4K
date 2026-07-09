<?php

namespace App\controllers;

use App\Config\Validator;
use App\controllers\AbstractController;
use App\entity\User;
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
    public function register()
    {
        if ($this->request->isPost()) {
            Validator::validate([
                "nom" => ["vide"],
                "username" => ["vide"],
                "email" => ["vide", "email"],
                "password" => ["vide"],
            ], $this->request->post());
            if (Validator::noErrors()) {
                $nom = $this->request->post('nom');
                $username = $this->request->post('username');
                $email = $this->request->post('email');
                $password = $this->request->post('password');
                $user = User::create($nom, $username, $email, $password);
                if ($this->ressourceService->registerRessource($user)) {
                    $this->redirect('/login');
                    exit;
                }
            } else {
                $this->render('auth/register', ["errors" => Validator::getErrors(), "olds" => Validator::getOldValues($this->request->post())]);
            }
        }
        $this->render('inscription');
    }
}
