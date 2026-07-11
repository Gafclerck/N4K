<?php

namespace App\controllers;

use App\config\Request;
use App\Config\Validator;
use App\Config\Session;
use App\controllers\AbstractController;
use App\Entity\User;
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
        if (Request::isPost()) {
            $validator = new Validator();
            $validator->validate([
                "nom" => ["vide"],
                "username" => ["vide"],
                "email" => ["vide", "email"],
                "password" => ["vide"],
            ], Request::post());
            if ($validator->noErrors()) {
                $nom = Request::post('nom');
                $username = Request::post('username');
                $email = Request::post('email');
                $password = Request::post('password');
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $user = User::create($nom, $username, $email, $hashedPassword);
                if ($this->userService->registerUser($user)) {
                    $this->redirect('/login');
                    exit;
                }
            } else {
                $this->render('inscription', ["errors" => $validator->getErrors(), "olds" => $validator->getOldValues(Request::post())]);
            }
        }
        $this->render('inscription');
    }

    public function login()
    {
        if (Request::isPost()) {
            $validator = new Validator();
            $validator->validate([
                "username" => ["vide"],
                "password" => ["vide"],
            ], Request::post());
            if ($validator->noErrors()) {
                $username = Request::post('username');
                $password = Request::post('password');
                $user = $this->userService->authenticateUser($username, $password);
                if ($user !== null) {
                    Session::set("user", $user);
                    $this->redirect('/index');
                    exit;
                }
            }
            $this->render('login', ["errors" => $validator->getErrors(), "olds" => $validator->getOldValues(Request::post())]);
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
