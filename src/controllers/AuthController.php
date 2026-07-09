<?php

namespace App\controllers;

use App\Config\Validator;
use App\Config\Session;
use App\controllers\AbstractController;
use App\entity\User;
use App\services\UserService;

class AuthController extends AbstractController
{
    private UserService $userService;
    private static ?AuthController $instance = null;
    private function __construct()
    {
        parent::__construct();
        $this->userService = new UserService();
    }

    public static function getInstance(): AuthController
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function authRequired(): void
    {
        if (!Session::isConnected()) {
            $this->redirect('/login');
        }
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
                if ($this->userService->registerUser($user)) {
                    $this->redirect('/login');
                    exit;
                }
            } else {
                $this->render('inscription', ["errors" => Validator::getErrors(), "olds" => Validator::getOldValues($this->request->post())]);
            }
        }
        $this->render('inscription');
    }

    public function login()
    {
        if ($this->request->isPost()) {
            Validator::validate([
                "username" => ["vide"],
                "password" => ["vide"],
            ], $this->request->post());
            if (Validator::noErrors()) {
                $username = $this->request->post('username');
                $password = $this->request->post('password');
                $user = $this->userService->authenticateUser($username, $password);
                if ($user !== null) {
                    Session::set("user", $user);
                    $this->redirect('/index');
                    exit;
                }
            }
            $this->render('login', ["errors" => Validator::getErrors(), "olds" => Validator::getOldValues($this->request->post())]);
        }
        $this->render('login');
    }

    public function logout()
    {
        Session::remove("user");
        session_destroy();
        $this->redirect('/login');
        exit;
    }
}
