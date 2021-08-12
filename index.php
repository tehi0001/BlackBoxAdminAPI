<?php

require_once 'LiteRouter/router.class.php';
use LiteRouter\Router\Router;

$router = new Router();


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