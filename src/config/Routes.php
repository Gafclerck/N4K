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

// FAVORIS
$router->get("/favoris", 'UserController@favoris');

//PUBLICATIONS
$router->get("/mes-publications", 'UserController@mesPubs');
$router->get("/publier", 'UserController@publier');
