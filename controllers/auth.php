<?php

$post = $request->getBody();

$db = Utils::get_db_object();

$user = $db->select_one(
    "SELECT firstname, lastname, role, password FROM administrators WHERE email=?",
    "s",
    array($post['email'])
);

if(empty($user)) {
    $response->json(array(
        "success" => false,
        "message" => "Invalid email or password"
    ));
}

if(Utils::verify_password($post['password'], $user['password'])) {
    $response->json(array(
        "success" => true,
        "data" => array("user" => $user),
        "token" => Utils::generate_session_token(array("user" => $post['email']))
    ));
}
else {
    $response->json(array(
        "success" => false,
        "message" => "Invalid email or password"
    ));
}

