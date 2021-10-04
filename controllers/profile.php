<?php
$user = Utils::get_user_from_session($response);

$db = Utils::get_db_object();

try {
    $profile = $db->select_one("SELECT email, firstname, lastname, role FROM administrators WHERE email=?", "s", array($user));

    $response->json(array(
        "success" => true,
        "data" => $profile
    ));
} catch (Exception $e) {
    $response->status(500)->send($e->getMessage());
}
