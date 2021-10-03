<?php

$user = Utils::get_user_from_session($response);

$db = Utils::get_db_object();

try {
    $promotion = $db->select_one(
        "SELECT * FROM promotions WHERE id=?",
        "i",
        array($request->getParam("id"))
    );

    $response->json(array(
        "success" => true,
        "data" => $promotion,
        "token" => Utils::renew_session_token($user)
    ));
} catch (Exception $e) {
    $response->status(500)->send($e->getMessage());
}