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

$router->get("/shipping-categories", function ($request, $response) {
    require_once 'controllers/get_shipping_categories.php';
});

$router->get("/products", function ($request, $response) {
    require_once 'controllers/get_products.php';
});

$router->get("/view-product/:id", function ($request, $response) {
    require_once 'controllers/view_product.php';
});

$router->get("/orders", function ($request, $response) {
    require_once 'controllers/get_orders.php';
});

$router->get("/view-order/:id", function ($request, $response) {
    require_once 'controllers/view_order.php';
});

$router->get("/users", function ($request, $response) {
    require_once 'controllers/get_users.php';
});

$router->get("/promotions", function ($request, $response) {
    require_once 'controllers/get_promotions.php';
});

$router->get("/promotions/:id", function ($request, $response) {
    require_once 'controllers/view_promotion.php';
});

$router->get("/profile", function ($request, $response) {
    require_once 'controllers/profile.php';
});

$router->get("/dashboard", function ($request, $response) {
    require_once 'controllers/dashboard.php';
});

$router->get("**", function ($request, $response) {
    $response->status(404)->send("404 Not Found");
});


//POST

$router->post("/auth", function ($request, $response) {
    require_once 'controllers/auth.php';
});

//Product Category
$router->post("/add-product-category", function ($request, $response) {
    require_once 'controllers/add_product_category.php';
});

$router->post("/edit-product-category/:id", function ($request, $response) {
    require_once 'controllers/edit_product_category.php';
});

$router->post("/delete-product-category", function ($request, $response) {
    require_once 'controllers/delete_product_category.php';
});

//Product

$router->post("/add-product", function ($request, $response) {
    require_once 'controllers/add_product.php';
});

$router->post("/edit-product/:id", function ($request, $response) {
    require_once 'controllers/edit_product.php';
});

$router->post("/delete-product/", function ($request, $response) {
    require_once 'controllers/delete_product.php';
});

$router->post("/delete-review/", function ($request, $response) {
    require_once 'controllers/delete_review.php';
});

//Shipping Category

$router->post("/add-shipping-category", function ($request, $response) {
    require_once 'controllers/add_shipping_category.php';
});

$router->post("/edit-shipping-category/:id", function ($request, $response) {
    require_once 'controllers/edit_shipping_category.php';
});

$router->post("/delete-shipping-category", function ($request, $response) {
    require_once 'controllers/delete_shipping_category.php';
});

//Orders

$router->post("/change-order-status", function ($request, $response) {
    require_once 'controllers/change_order_status.php';
});

$router->post("/delete-order", function ($request, $response) {
    require_once 'controllers/delete_order.php';
});

//Promotions

$router->post("/add-promotion", function ($request, $response) {
    require_once 'controllers/add_promotion.php';
});

$router->post("/edit-promotion/:id", function ($request, $response) {
    require_once 'controllers/edit_promotion.php';
});

$router->post("/delete-promotion", function ($request, $response) {
    require_once 'controllers/delete_promotion.php';
});

//Profile & Settings

$router->post("/edit-profile", function ($request, $response) {
    require_once 'controllers/edit_profile.php';
});

$router->post("/change-password", function ($request, $response) {
    require_once 'controllers/change_password.php';
});

//Customers

$router->post("/delete-customer", function ($request, $response) {
    require_once 'controllers/delete_customer.php';
});

$router->post("/edit-customer/:id", function ($request, $response) {
    require_once 'controllers/edit_customer.php';
});


//404

$router->post("**", function ($request, $response) {
    $response->status(404)->send("404 Not Found");
});