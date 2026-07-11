<?php

namespace App\controllers;

use App\services\GroupeService;

class AbstractController
{
    private GroupeService $groupeService;

    public function __construct()
    {
        $this->groupeService = new GroupeService();
    }

    public function render(string $view, array $data = [])
    {
        $data['myGroups'] = $data['myGroups'] ?? $this->groupeService->getGroupesByCurrentUser();
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
