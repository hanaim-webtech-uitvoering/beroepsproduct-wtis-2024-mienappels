<?php
require_once 'db_connectie.php';
include './functions/error.php';
global $db; 
$db = maakVerbinding();
session_start();
function getOrders(){

    global $db;
    $query = 'SELECT * FROM Pizza_Order where client_username = :username';
    $stmt = $db->prepare($query);
    $stmt->execute(['username' => $_SESSION['username']]);
    $orders = $stmt->fetchAll();

    echo '<h1> Orders </h1>';
    echo '<table border="1">';
    echo '<tr><th>Order ID</th><th>Order Date</th><th>Order Status</th><th>Items</th><th>Total Price</th></tr>';
    foreach($orders as $order){
        echo '<tr>';
        echo '<td>' . $order['order_id'] . '</td>';
        echo '<td>' . $order['datetime'] . '</td>';

        switch ($order['status']) {
            case 0:
                $status = 'Received';
                break;
            case 1:
                $status = 'Prep';
                break;
            case 2:
                $status = 'Ready';
                break;
            case 3:
                $status = 'Delivered';
                break;
            default:
                $status = 'Unknown';
                break;
        }

        echo '<td>' . $status . '</td>';






        $query = 'SELECT * FROM Pizza_Order_Product inner join Product on Pizza_Order_Product.product_name = Product.name
 WHERE order_id = :order_id';
        $stmt = $db->prepare($query);
        $stmt->execute(['order_id' => $order['order_id']]);
        $order_details = $stmt->fetchAll();
        $total = 0;
        echo '<td>';
        echo '<table border="1">';
        echo '<tr><th>Product Name</th><th>Amount</th></tr>';
        foreach($order_details as $order_detail){
            echo '<tr>';
            echo '<td>' . $order_detail['product_name'] . '</td>';
            echo '<td>' . $order_detail['quantity'] . '</td>';
            echo '</tr>';
            $total += $order_detail['quantity'] * $order_detail['price'];
        }
        echo '</table>';
        echo '</td>';
        echo '<td>€' . $total . '</td>';
        

    

        
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
    getOrders();
    ?>
</body>
</html>