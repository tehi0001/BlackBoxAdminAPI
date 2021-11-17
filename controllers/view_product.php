<?php

$user = Utils::get_user_from_session($response);

$db = Utils::get_db_object();

$id = $request->getParam("id");

try {
    $product = $db->select_one(
        "SELECT products.*, product_categories.category_name FROM products JOIN product_categories WHERE products.id=? AND products.category = product_categories.id",
        "i",
        array($id)
    );

    if(!empty($product)) {
        $product['images'] = $db->select_many(
            "SELECT * FROM product_images WHERE product=?",
            "i",
            array($id)
        );

        $product['properties'] = $db->select_many(
            "SELECT * FROM product_properties WHERE product=?",
            "i",
            array($id)
        );

        $product['reviews'] = $db->select_many(
            "SELECT product_reviews.*, users.firstname, users.lastname FROM product_reviews, users WHERE product_reviews.user = users.id AND product_reviews.product=? ORDER BY product_reviews.entrydate DESC",
            "i",
            array($id)
        );
    
        $average = $db->select_one("SELECT AVG(rating) AS average FROM product_reviews WHERE product=?", "i", array($id));
        $product['average_rating'] = $average['average'];
    }

    $response->json(array(
        "success" => true,
        "data" => $product
    ));

} catch (Exception $e) {
    $response->status(500)->send($e->getMessage());
}