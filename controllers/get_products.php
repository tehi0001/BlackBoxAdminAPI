<?php

$user = Utils::get_user_from_session($response);

$post = $request->getBody();

$db = Utils::get_db_object();

try {
    $products = $db->select_many(
        "SELECT products.id, product_categories.category_name AS category, products.product_name AS name, products.price, products.stock FROM products JOIN product_categories ON products.category = product_categories.id ORDER BY entrydate DESC"
    );
    for($i = 0; $i < sizeof($products); $i++) {
        $image = $db->select_one("SELECT image FROM product_images WHERE product=? ORDER BY entrydate ASC", "i", array($products[$i]['id']));
        $products[$i]['image'] = stripcslashes($image['image']);
    }

    $response->json(array(
        "success" => true,
        "data" => $products,
        "token" => Utils::renew_session_token($user)
    ));
}
catch (Exception $e) {
    $response->status(500)->send($e->getMessage());
}

