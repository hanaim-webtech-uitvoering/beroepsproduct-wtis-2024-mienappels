<?php
require_once './functions/db_connectie.php';
session_start();
global $db;
$db = maakVerbinding();
include './functions/header_footer.php';
include './functions/showOrder.php';
include './functions/checks.php';


function checkOrderValidity()
{
    global $db;
    $query = 'SELECT * FROM Pizza_Order';
    $stmt = $db->prepare($query);
    $stmt->execute();
    $orders = $stmt->fetchAll();

    $_POST['orderid'] = htmlspecialchars($_POST['orderid']); // too check if the order id is valid
    $orderValid = false;
    foreach ($orders as $order) {
        if ($order['order_id'] == $_POST['orderid']) {
            $orderValid = true;
        }
    }
    return $orderValid;
}

function checkReturnPage()
{
    return $_SERVER['HTTP_REFERER'] == 'http://localhost:8080/Personnel.php' || $_SERVER['HTTP_REFERER'] == 'http://localhost:8080/detail-personnel.php';
}


if (!isset($_POST['orderid']) || !checkIfPersonnel() || !checkOrderValidity() || !checkReturnPage()) {
    header('Location: index.php?error=403');
}

function getDetailOrder()
{
    global $db;
    $query = 'SELECT * FROM Pizza_Order where order_id = :order_id';
    $stmt = $db->prepare($query);
    $stmt->execute(['order_id' => $_POST['orderid']]);
    $order = $stmt->fetch();
    echo '<h1> Order Status </h1>';
    echo '<table border="1">';
    echo '<tr><th>Order ID</th><th>Order Date</th><th>Address</th><th>Client Name</th><th>Personnel assigned</th><th>Order Status</th><th>Order Details</th></tr>';
    showOrder($order);
}


?>


<?php

getHeader('Detail Order');
getDetailOrder();
getFooter();

?>