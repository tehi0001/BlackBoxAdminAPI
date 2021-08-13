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

    require_once 'conf/superuser.php';

    $password = Utils::hash_password($post['password']);

    $query = $db->query(
        "INSERT INTO administrators (firstname, lastname, email, password, joindate, role) VALUES (?, ?, ?, ?, UTC_TIMESTAMP(), ?)",
        "sssss",
        array(
            $superuser_firstname,
            $superuser_lastname,
            $superuser_email,
            $password,
            "root"
        )
    );

    if(empty($query)) {
        $response->send("System successfully initialized. You may sign in as with your root email and password");
    }

} catch (Exception $e) {
    $response->status(500)->send($e->getMessage());
}

