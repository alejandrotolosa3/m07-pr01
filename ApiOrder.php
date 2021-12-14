<?php
include_once 'OrderSeeder.php';


$order = new OrderSeeder();
$result = $order->getOrders();

if ($result) {
    http_response_code(200);
    echo json_encode($result);
} else {
    http_response_code(404);
    echo json_encode(null);
}
