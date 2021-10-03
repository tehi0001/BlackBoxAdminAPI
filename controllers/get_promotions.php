<?php
$user = Utils::get_user_from_session($response);

$db = Utils::get_db_object();

try {
    $promotions = $db->select_many("SELECT * FROM promotions ORDER BY entrydate DESC");

    foreach ($promotions as $index => $promotion) {
        unset($promotions[$index]['image']);
    }

    $response->json(array(
        "success" => true,
        "data" => $promotions,
        "token" => Utils::renew_session_token($user)
    ));
} catch (Exception $e) {
}

