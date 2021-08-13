<?php

$user = Utils::get_user_from_session($response);

$db = Utils::get_db_object();

$id = $request->getParam("id");

$post = $request->getBody();

try {
    $category_exists = $db->select_one(
        "SELECT id FROM product_categories WHERE category_name=?",
        "s",
        array($post['name'])
    );

    if(!empty($category_exists) && $category_exists['id'] != $request->getParam("id")) {
        $response->json(array(
            "success" => false,
            "message" => "Category name already exists",
            "token" => Utils::renew_session_token($user)
        ));
    }

    $db->query(
        "UPDATE product_categories SET category_name=?, description=? WHERE id=?",
        "ssi",
        array(
            $post['name'],
            $post['description'],
            $request->getParam("id")
        )
    );

    $response->json(array(
        "success" => true,
        "token" => Utils::renew_session_token($user)
    ));
} catch (Exception $e) {
    $response->status(500)->send($e->getMessage());
}