<?php
$user = Utils::get_user_from_session($response);

$db = Utils::get_db_object();

try {
    $categories = $db->select_many("SELECT * FROM shipping_categories ORDER BY category_name ASC");

    $response->json(array(
        "success" => true,
        "data" => $categories,
        "token" => Utils::renew_session_token($user)
    ));
} catch (Exception $e) {
    $response->status(500)->send($e->getMessage());
}