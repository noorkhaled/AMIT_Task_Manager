<?php

declare(strict_types=1);

use App\Core\Router;

require __DIR__ . '/../vendor/autoload.php';

session_start();

$router = new Router();

// Auth Routes
$router->get('/',            'AuthController@loginForm');
$router->get('/login',       'AuthController@loginForm');
$router->post('/login',      'AuthController@login');
$router->get('/register',    'AuthController@registerForm');
$router->post('/register',   'AuthController@register');
$router->post('/logout',     'AuthController@logout');

// Tasks Routes
$router->get('/tasks',           'TaskController@index');
$router->get('/tasks/create',    'TaskController@createForm');
$router->post('/tasks',          'TaskController@store');
$router->get('/task/show',          'TaskController@show');
$router->get('/tasks/edit',      'TaskController@editForm');
$router->post('/tasks/update',   'TaskController@update');
$router->post('/tasks/delete',   'TaskController@destroy');

$router->dispatch();
