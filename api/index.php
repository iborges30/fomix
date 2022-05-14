<?php

use Source\Core\Connect;

require '../vendor/autoload.php';
header("Content-Type: application/json;charset=utf-8");
$apiKey = "836075c1846cbbcce1fffc351b0a52975f06f7a6";
$key = filter_input(INPUT_GET, 'api_key', FILTER_SANITIZE_STRING);
if ($apiKey != $key) {
    die();
}

$start = filter_input(INPUT_GET, 'start', FILTER_SANITIZE_STRING);
$end = filter_input(INPUT_GET, 'end', FILTER_SANITIZE_STRING);
$enterpriseId = filter_input(INPUT_GET, 'enterprise_id', FILTER_SANITIZE_STRING);
$pdo = Connect::getInstance();

$sql = "SELECT * FROM orders WHERE enterprise_id = '{$enterpriseId}' AND status = 4";
if ($start && $end) {

    $sql = "SELECT * FROM orders WHERE created BETWEEN '{$start}' AND '{$end}' AND enterprise_id = '{$enterpriseId}' AND status = 4";
}
$query = $pdo->query($sql);
$orders = $query->fetchAll();
$query2 = $pdo->query("SELECT * FROM orders_items LEFT JOIN products ON orders_items.product_id = products.id");
$ordersItems = $query2->fetchAll();

foreach ($orders as $key => $order) {
    foreach ($ordersItems as $orderItem) {
        if ($orderItem->order_id == $order->id) {
            $orders[$key]->orders_items[] = $orderItem;
        }
    }
}
echo json_encode($orders);
