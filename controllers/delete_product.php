<?php

$user = Utils::get_user_from_session($response);

$post = $request->getBody();

$db = Utils::get_db_object();

try {
    $db->query("DELETE FROM products WHERE id=?", "i", array($post['id']));
    $response->json(array(
        "success" => true
    ));
} catch (Exception $e) {
    $response->status(500)->send($e->getMessage());
}