<?php

$user = Utils::get_user_from_session($response);

$db = Utils::get_db_object();

$post = $request->getBody();

try {
    $db->query("DELETE FROM orders WHERE id=?", "i", array($post['id']));

    $response->json(array(
        "success" => true
    ));
} catch (Exception $e) {
    $response->status(500)->send($e->getMessage());
}