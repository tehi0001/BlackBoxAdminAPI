<?php
$user = Utils::get_user_from_session($response);

$db = Utils::get_db_object();

try {
    $users = $db->select_many("SELECT users.*, (SELECT SUM(orders.total) FROM orders WHERE orders.user=users.id) AS total_spend FROM users");

    $response->json(array(
        "success" => true,
        "data" => $users
    ));
} catch (Exception $e) {
    $response->status(500)->send($e->getMessage());
}