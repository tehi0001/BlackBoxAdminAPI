<?php
$user = Utils::get_user_from_session($response);

$post = $request->getBody();

$db = Utils::get_db_object();

try {
    $db->query(
        "DELETE FROM product_categories WHERE id=?",
        "i",
        array($post['id'])
    );

    $response->json(array(
        "success" => true,
        "token" => Utils::renew_session_token($user)
    ));
} catch (Exception $e) {
    $response->status(500)->send($e->getMessage());
}