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
    }

    $response->json(array(
        "success" => true,
        "data" => $product
    ));

} catch (Exception $e) {
    $response->status(500)->send($e->getMessage());
}