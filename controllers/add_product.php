<?php

$user = Utils::get_user_from_session($response);

$post = $request->getBody();

$db = Utils::get_db_object();

$product_exists = $db->select_one(
    "SELECT product_name FROM products WHERE category=? AND product_name=?",
    "is",
    array($post['category'], $post['name'])
);

if(!empty($product_exists)) {
    $response->json(array(
        "success" => false,
        "message" => "Product already exists in selected category"
    ));
}

try {
    $db->query(
        "INSERT INTO products (category, product_name, manufacturer, description, stock, entrydate, price, discount) VALUES (?, ?, ?, ?, ?, UTC_TIMESTAMP(), ?, ?)",
        "isssiii",
        array($post['category'], $post['name'], $post['manufacturer'], $post['description'], $post['stock'], $post['price'], $post['discount'])
    );

    $insert_result = $db->getStatementResult();
    $product_id = $insert_result->insert_id;

    if(isset($post['properties']) && sizeof($post['properties']) > 0) {
        foreach ($post['properties'] as $property) {
            $db->query(
                "INSERT INTO product_properties (product, property_type, property_name, value) VALUES (?, ?, ?, ?)",
                "isss",
                array($product_id, $property['type'], $property['name'], $property['value'])
            );
        }
    }

    if(isset($post['images']) && sizeof($post['images']) > 0) {
        foreach ($post['images'] as $image) {
            $db->query(
                "INSERT INTO product_images (product, entrydate, image) VALUES (?, UTC_TIMESTAMP(), ?)",
                "is",
                array($product_id, $image)
            );
        }
    }

    $response->json(array(
        "success" => true,
        "token" => Utils::renew_session_token($user)
    ));


} catch (Exception $e) {
    $response->status(500)->send($e->getMessage());
}