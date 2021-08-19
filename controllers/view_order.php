<?php


$user = Utils::get_user_from_session($response);

$db = Utils::get_db_object();

try {

    $order = $db->select_one(
        "SELECT orders.*, users.email, shipping_categories.category_name AS shipping_category FROM orders, users, shipping_categories WHERE orders.shipping_category=shipping_categories.id AND orders.user=users.id AND orders.order_number=?",
        "i",
        array($request->getParam("id"))
    );

    $order['billing'] = $db->select_one("SELECT * FROM billing_addresses WHERE id=?", "i", array($order['billing_address']));

    $order['shipping'] = $db->select_one("SELECT * FROM shipping_addresses WHERE id=?", "i", array($order['shipping_address']));

    $order['items'] = $db->select_many(
        "SELECT order_items.*, products.product_name FROM order_items, products WHERE order_items.product=products.id AND order_id=?", "i", array($order['id'])
    );

    $subtotal = $db->select_one("SELECT SUM(total) AS subtotal FROM order_items WHERE order_id=?", "i", array($order['id']));

    $order['subtotal'] = $subtotal['subtotal'];

    $response->json(array(
        "success" => true,
        "data" => $order
    ));

} catch (Exception $e) {
    $response->status(500)->send($e->getMessage());
}

