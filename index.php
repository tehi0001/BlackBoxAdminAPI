<?php
/*
 ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

require_once 'init.php';

use LiteRouter\Router\Router as Router;

$router = new Router();

//First Run

$router->post("/first-run", function ($request, $response) {
    require_once 'controllers/first_run.php';
});



//GET

$router->get("/", function ($request, $response) {
    $response->send("Welcome to BlackBox Admin API");
});

$router->get("**", function ($request, $response) {
    $response->status(404)->send("404 Not Found");
});


//POST

$router->post("/auth", function ($request, $response) {
    require_once 'controllers/auth.php';
});

$router->post("**", function ($request, $response) {
    $response->status(404)->send("404 Not Found");
});