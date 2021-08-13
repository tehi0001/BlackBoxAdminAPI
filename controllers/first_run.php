<?php

$post = $request->getBody();

$db = Utils::get_db_object($response);

try {

    $super_user_exists = $db->select_one(
        "SELECT email FROM administrators WHERE role=?",
        "s",
        array("root")
    );

    if(!empty($super_user_exists)) {
        $response->status(400)->send("System already initialized");
    }


    $password = Utils::hash_password($post['password']);

    $query = $db->query(
        "INSERT INTO administrators (firstname, lastname, email, password, joindate, role) VALUES (?, ?, ?, ?, UTC_TIMESTAMP(), ?)",
        "sssss",
        array('Super', 'User', 'superuser@blackbox.com', $password,'root')
    );

    if($query == null) {
        $response->send("System successfully initialized. You may sign in as with your root email and password");
    }

} catch (Exception $e) {
    $response->status(500)->send($e->getMessage());
}

