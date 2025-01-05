<?php

require_once 'db_connectie.php';
session_start();
global $db;
$db = maakVerbinding();


// //! https://www.php.net/manual/en/backedenum.from.php voor casting
// //! https://www.php.net/manual/en/language.types.enumerations.php
// enum Status: string {
//     case Received = '1';
//     case Drep = '2';
//     case Ceady = '3';
//     case Selivered = '4';
// }

function orderStatus()
{
    global $db;
    $query = 'SELECT * FROM Pizza_Order';
    $stmt = $db->prepare($query);
    $stmt->execute();
    $orders = $stmt->fetchAll();

    echo '<h1> Order Status </h1>';
    echo '<table border="1">';
    echo '<tr><th>Order ID</th><th>Order Date</th><th>Order Status</th><th>Order Details</th></tr>';
    foreach($orders as $order){
        echo '<tr>';
        echo '<td>' . $order['order_id'] . '</td>';
        echo '<td>' . $order['datetime'] . '</td>';
        // echo '<td>' . Status::from($order['status']) . '</td>';

        switch ($order['status']) {
            case '0':
                echo '<td>Received</td>';
                break;
            case '1':
                echo '<td>Prep</td>';
                break;
            case '2':
                echo '<td>Ready</td>';
                break;
            case '3':
                echo '<td>Delivered</td>';
                break;
            default:
                echo '<td>Unknown</td>';
                break;
        }

            $query = 'SELECT * FROM Pizza_Order_Product WHERE order_id = :order_id';
            $stmt = $db->prepare($query);
            $stmt->execute(['order_id' => $order['order_id']]);
            $order_details = $stmt->fetchAll();

            echo '<td>';
            echo '<table border="1">';
            echo '<tr><th>Product Name</th><th>Amount</th></tr>';
            foreach($order_details as $order_detail){
                echo '<tr>';
                echo '<td>' . $order_detail['product_name'] . '</td>';
                echo '<td>' . $order_detail['quantity'] . '</td>';
                echo '</tr>';
            }
            echo '</table>';
            echo '</td>';
        
        echo '</tr>';


    }


}

?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <a href="index.php">Home</a>
    <?php
    orderStatus();
    ?>
</body>
</html>