<?php

$user = Utils::get_user_from_session($response);

$post = $request->getBody();

$db = Utils::get_db_object();

$id = $request->getParam("id");

try {
    $product_exists = $db->select_one(
        "SELECT product_name FROM products WHERE category=? AND product_name=? AND id!=?",
        "isi",
        array($post['category'], $post['name'], $id)
    );

    if(!empty($product_exists)) {
        $response->json(array(
            "success" => false,
            "message" => "Duplicate product name in selected category"
        ));
    }
    $db->query(
        "UPDATE products SET category=?, product_name=?, manufacturer=?, description=?, stock=?, price=?, discount=? WHERE id=?",
        "ssssiddi",
        array($post['category'], $post['name'], $post['manufacturer'], nl2br($post['description']), $post['stock'], $post['price'], $post['discount'], $id)
    );


    $db->query("DELETE FROM product_images WHERE product=?", "i", array($id));
    $db->query("DELETE FROM product_properties WHERE product=?", "i", array($id));

        if(isset($post['properties']) && sizeof($post['properties']) > 0) {
            foreach ($post['properties'] as $property) {
                $db->query(
                    "INSERT INTO product_properties (product, property_type, property_name, value) VALUES (?, ?, ?, ?)",
                    "isss",
                    array($id, $property['property_type'], $property['property_name'], $property['value'])
                );
            }
        }

    if(isset($post['images']) && sizeof($post['images']) > 0) {
        foreach ($post['images'] as $image) {
            $db->query(
                "INSERT INTO product_images (product, entrydate, image) VALUES (?, UTC_TIMESTAMP(), ?)",
                "is",
                array($id, $image)
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

