<?php
$user = Utils::get_user_from_session($response);

$db = Utils::get_db_object();

$post = $request->getBody();

try {
    $db->query(
        "UPDATE users SET firstname=?, lastname=?, email=?, status=? WHERE id=?",
        "sssii",
        array($post['firstname'], $post['lastname'], $post['email'], $post['status'], $request->getParam("id"))
    );

    $response->json(array(
        "success" => true,
        "token" => Utils::renew_session_token($user)
    ));

} catch (Exception $e) {
    $response->status(500)->send($e->getMessage());
}