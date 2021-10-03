<?php
$user = Utils::get_user_from_session($response);

$post = $request->getBody();

$db = Utils::get_db_object();

try {
    $db->query(
        "UPDATE promotions SET name=?, description=?, start_date=?, end_date=?, url=?, status=?, image=? WHERE id=?",
        "sssssisi",
        array($post['name'], $post['description'], $post['startDate'], $post['endDate'], $post['url'], $post['status'], $post['image'], $request->getParam("id"))
    );

    $response->json(array(
        "success" => true,
        "token" => Utils::renew_session_token($user)
    ));
} catch (Exception $e) {
    $response->status(500)->send($e->getMessage());
}