<?php
$user = Utils::get_user_from_session($response);

$db = Utils::get_db_object();

$post = $request->getBody();

try {
    $admin = $db->select_one("SELECT password FROM administrators WHERE email=?", "s", array($user));

    if(!Utils::verify_password($post['oldPassword'], $admin['password'])) {
        $response->json(array(
            "success" => false,
            "message" => "Invalid old password. Please try again",
            "token" => Utils::renew_session_token($user)
        ));
    }
    else {
        $db->query(
            "UPDATE administrators SET password=? WHERE email=?",
            "ss",
            array(Utils::hash_password($post['newPassword']), $user)
        );

        $response->json(array(
            "success" => true,
            "token" => Utils::renew_session_token($user)
        ));
    }
}
catch (Exception $e) {
    $response->status(500)->send($e->getMessage());
}
