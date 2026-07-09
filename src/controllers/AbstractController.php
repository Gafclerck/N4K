<?php

namespace App\controllers;

use App\Config\Request;

class AbstractController
{
    protected Request $request;
    public function __construct()
    {
        $this->request = new Request();
    }

    public function render(string $view, array $data = [])
    {
        extract($data);
        require_once dirname(__DIR__) . "/views/inc/header.html.php";
        require_once dirname(__DIR__) . "/views/" . $view . ".html.php";
        require_once dirname(__DIR__) . "/views/inc/footer.html.php";
    }

    public function pageNotFound()
    {
        http_response_code(404);
        $this->render("404");
        exit();
    }

    public function redirect(string $url)
    {
        header("Location: " . WEBROOT . $url);
        exit();
    }
}
