<?php

namespace App\controllers;

use App\controllers\AbstractController;

class UserController extends AbstractController
{
    private static ?UserController $instance = null;
    private function __construct()
    {
        parent::__construct();
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
        $this->render('index');
    }

    public function favoris()
    {
        $this->render("favoris");
    }
    public function mesPubs()
    {
        $this->render("mes-publications");
    }
    public function publier()
    {
        $this->render("publier");
    }
}
