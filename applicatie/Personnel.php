<?php

require_once './functions/db_connectie.php';
session_start();
global $db;
$db = maakVerbinding();
include './functions/header_footer.php';
include './functions/showOrder.php';
include './functions/checks.php';

// //! https://www.php.net/manual/en/backedenum.from.php voor casting
// //! https://www.php.net/manual/en/language.types.enumerations.php
// enum Status: string {
//     case Received = '1';
//     case Drep = '2';
//     case Ceady = '3';
//     case Selivered = '4';
// }

if(checkIfClient()){
    header('Location: index.php?error=403');
}

if(!checkIfPersonnel()){
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
    $query = 'select * from Pizza_Order' . ($_SESSION['showDelivered'] ? '' : ' where status != 3') . ' order by datetime, status desc'; // ik haat ternary operators maar hier moest het voor ruimte efficiency
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
        showOrder($order);
    }


}






?>







    <?php
        getHeader('Personnel Page');

    orderStatus();
    getFooter();

    ?>
