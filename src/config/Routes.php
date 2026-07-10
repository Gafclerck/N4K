<?php


declare(strict_types=1);

// INDEX
$router->get('/', 'AuthController@login');
$router->get('/index', 'UserController@index');


// AUTHETIFICATION
$router->get('/register', 'AuthController@register');
$router->post('/register', 'AuthController@register');

$router->get('/login', 'AuthController@login');
$router->post('/login', 'AuthController@login');

$router->get('/logout', 'AuthController@logout');

// GROUPES
$router->get('/groupes', 'GroupeController@voirsGroupes');
$router->get('/groupes/create', 'GroupeController@createGroupe');
$router->post('/groupes/create', 'GroupeController@createGroupe');
$router->post('/groupes/join', 'GroupeController@joinGroupe');
$router->get('/groupe/{id}', 'GroupeController@voirGroupe');

// FAVORIS
$router->get("/favoris", 'UserController@favoris');

// PUBLICATIONS
$router->get("/publier", 'RessourceController@publier');
$router->post("/publier", 'RessourceController@publier');

$router->get("/groupe/{id}/publier", 'RessourceController@publierDansGroupe');
$router->post("/groupe/{id}/publier", 'RessourceController@publierDansGroupe');

$router->get("/mes-ressources", 'RessourceController@voirMesRessources');
$router->get("/mes-publications", 'RessourceController@voirMesRessources');
$router->get("/groupe/{id}/ressources", 'RessourceController@voirRessourcesByGroup');
$router->get("/ressource/{id}/download", 'RessourceController@download');
$router->get("/ressource/{id}/view", 'RessourceController@view');
