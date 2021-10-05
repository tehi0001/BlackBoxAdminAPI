<?php
$user = Utils::get_user_from_session($response);

$db = Utils::get_db_object();

try {

    $data = [];

    $orders = $db->select_one("SELECT AVG(total) as average_sales, COUNT(*) as total_orders FROM orders");

    $data['average_sales'] = $orders['average_sales'];
    $data['total_orders'] = $orders['total_orders'];

    $customers = $db->select_one("SELECT COUNT(DISTINCT(email)) as customer_count FROM users");

    $data['customer_count'] = $customers['customer_count'];

    $sales = $db->select_many(
        "SELECT MONTH(date) AS month, SUM(total) as total FROM orders GROUP BY MONTH(date) ORDER BY MONTH(date) ASC"
    );

    $data['sales'] = $sales;

    $province = $db->select_many(
        "SELECT province, COUNT(*) AS users FROm billing_addresses GROUP BY province"
    );

    $data['province'] = $province;

    $response->json(array(
        "success" => true,
        "data" => $data
    ));

} catch (Exception $e) {
    $response->status(500)->send($e->getMessage());
}