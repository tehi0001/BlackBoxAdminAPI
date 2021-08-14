<?php
$user = Utils::get_user_from_session($response);

$post = $request->getBody();

$db = Utils::get_db_object();

$category_exists = $db->select_one(
    "SELECT id FROM shipping_categories WHERE category_name=?",
    "s",
    array($post['name'])
);

if(!empty($category_exists)) {
    $response->json(array(
        "success" => false,
        "message" => "Duplicate shipping category name",
        "token" => Utils::renew_session_token($user)
    ));
}

try {
    $db->query(
        "INSERT INTO shipping_categories (category_name, description, conditions, cost) VALUES (?, ?, ?, ?)",
        "sssd",
        array($post['name'], $post['description'], $post['conditions'], $post['cost'])
    );

    $response->json(array(
        "success" => true,
        "token" => Utils::renew_session_token($user)
    ));
} catch (Exception $e) {
}