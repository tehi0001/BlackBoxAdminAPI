<?php
/*
 ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

require_once 'init.php';
require_once 'vendor/autoload.php';

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

$router->get("/product-categories", function ($request, $response) {
    require_once 'controllers/get_product_categories.php';
});

$router->get("**", function ($request, $response) {
    $response->status(404)->send("404 Not Found");
});


//POST

$router->post("/auth", function ($request, $response) {
    require_once 'controllers/auth.php';
});

$router->post("/add-product-category", function ($request, $response) {
    require_once 'controllers/add_product_category.php';
});

$router->post("/edit-product-category/:id", function ($request, $response) {
    require_once 'controllers/edit_product_category.php';
});

$router->post("/delete-product-category", function ($request, $response) {
    require_once 'controllers/delete_product_category.php';
});

$router->post("**", function ($request, $response) {
    $response->status(404)->send("404 Not Found");
});