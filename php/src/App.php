<?php

namespace App;

use App\config\Router;
use App\config\Request;
use App\Config\Session;
use App\controllers\AuthController;

class App
{
    public static function main()
    {
        Session::start();

        $publicRoutes = ['/', '/login', '/register'];
        if (!in_array(Request::uri(), $publicRoutes)) {
            AuthController::getInstance()->authRequired();
        }

        $router = new Router();
        include "src/config/Routes.php";
        $router->route();
    }
}
