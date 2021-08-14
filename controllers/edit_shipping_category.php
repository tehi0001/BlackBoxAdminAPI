<?php

$user = Utils::get_user_from_session($response);

$db = Utils::get_db_object();

$id = $request->getParam("id");

$post = $request->getBody();

try {
    $category_exists = $db->select_one(
        "SELECT id FROM shipping_categories WHERE category_name=?",
        "s",
        array($post['name'])
    );

    if(!empty($category_exists) && $category_exists['id'] != $request->getParam("id")) {
        $response->json(array(
            "success" => false,
            "message" => "Duplicate shipping category name",
            "token" => Utils::renew_session_token($user)
        ));
    }

    $db->query(
        "UPDATE shipping_categories SET category_name=?, description=?, conditions=?, cost=? WHERE id=?",
        "sssdi",
        array(
            $post['name'],
            $post['description'],
            $post['conditions'],
            $post['cost'],
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