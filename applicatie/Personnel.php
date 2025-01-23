<?php

require_once 'db_connectie.php';
session_start();
global $db;
$db = maakVerbinding();
include './functions/header_footer.php';



// //! https://www.php.net/manual/en/backedenum.from.php voor casting
// //! https://www.php.net/manual/en/language.types.enumerations.php
// enum Status: string {
//     case Received = '1';
//     case Drep = '2';
//     case Ceady = '3';
//     case Selivered = '4';
// }

if($_SESSION['role'] == 'Client'){
    header('Location: index.php?error=403');
}

if(!($_SESSION['role'] == 'Personnel')){
    header('Location: index.php?error=403');
}

if(isset($_POST['update'])){
    $order_id = htmlspecialchars($_POST['order_id']);
    $status = htmlspecialchars($_POST['status']);
    $query = 'UPDATE Pizza_Order SET status = :status WHERE order_id = :order_id';
    $stmt = $db->prepare($query);
    $stmt->execute(['status' => $status, 'order_id' => $order_id]);
}



function orderStatus()
{

    if(!isset($_SESSION['showDelivered'])){
        $_SESSION['showDelivered'] = 0;
    }

    if(isset($_POST['showDelivered'])){
        $_SESSION['showDelivered'] = !$_SESSION['showDelivered'];
    }


    global $db;
    $query = 'select * from Pizza_Order' . ($_SESSION['showDelivered'] ? '' : ' where status != 3') . ' order by datetime, status desc'; // ik haat tertiary operators maar hier moest het voor ruimte efficiency
    $stmt = $db->prepare($query);
    $stmt->execute();
    $orders = $stmt->fetchAll();

    echo '<h1> Order Status </h1>';
    echo '<form action="./Personnel.php" method="post">';
    echo '<input type="submit" name="showDelivered" value="Toggle showing delivered">';
    echo '</form>';
    echo '<table border="1">';
    echo '<tr><th>Order ID</th><th>Order Date</th><th>Address</th><th>Client Name</th><th>Personnel assigned</th><th>Order Status</th><th>Order Details</th></tr>';
    foreach($orders as $order){
        echo '<tr>';
        echo '<td>' . $order['order_id'] . '</td>';
        echo '<td>' . $order['datetime'] . '</td>';
        echo '<td>' . $order['address'] . '</td>';
        echo '<td>' . $order['client_name'] . '</td>';
        echo '<td>' . $order['personnel_username'] . '</td>';


        echo '<td>';
        echo '<form action="./Personnel.php" method="post">';
        echo '<input type="hidden" name="order_id" value="' . $order['order_id'] . '">';
        echo '<select name="status" >';
        $statuses = [
            '0' => 'Received',
            '1' => 'Prep',
            '2' => 'Ready',
            '3' => 'Delivered'
        ];

        foreach ($statuses as $value => $label) {
            $selected = '';
            if ($order['status'] == $value) {
            $selected = 'selected';
            }
            echo "<option value=\"$value\" $selected>$label</option>";
        }

        echo '</select>';
        echo '<input type="submit" name="update" value="update">';
        echo '</form>';

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







    <?php
        getHeader('checkout');

    orderStatus();
    getFooter();

    ?>
