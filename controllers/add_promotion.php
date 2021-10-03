<?php

$user = Utils::get_user_from_session($response);

$post = $request->getBody();

$db = Utils::get_db_object();

try {
    $db->query(
        "INSERT INTO promotions (name, description, entrydate, start_date, end_date, status, image, url) VALUES (?, ?, NOW(), ?, ?, ?, ?, ?)",
        "ssssiss",
        array($post['name'], $post['description'], $post['startDate'], $post['endDate'], $post['status'], $post['image'], $post['url'])
    );
    $response->json(array(
        "success" => true,
        "token" => Utils::renew_session_token($user)
    ));
} catch (Exception $e) {
    $response->status(500)->send($e->getMessage());
}

