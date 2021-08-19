<?php

$user = Utils::get_user_from_session($response);

$db = Utils::get_db_object();

try {
    $orders = $db->select_many(
        "SELECT orders.order_number, orders.date, orders.payment_method, orders.total, orders.status, billing_addresses.firstname,
           billing_addresses.lastname FROM orders JOIN billing_addresses WHERE orders.billing_address=billing_addresses.id ORDER BY orders.date DESC"
    );

    $response->json(array(
        "success" => true,
        "data" => $orders
    ));
} catch (Exception $e) {
    $response->status(500)->send($e->getMessage());
}

