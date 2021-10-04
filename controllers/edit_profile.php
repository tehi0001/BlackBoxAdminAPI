<?php
$user = Utils::get_user_from_session($response);

$db = Utils::get_db_object();

$post = $request->getBody();

try {
    $db->query(
        "UPDATE administrators SET firstname=?, lastname=? WHERE email=?",
        "sss",
        array($post['firstname'], $post['lastname'], $user)
    );

    $response->json(array(
        "success" => true,
        "token" => Utils::renew_session_token($user)
    ));

} catch (Exception $e) {
    $response->status(500)->send($e->getMessage());
}