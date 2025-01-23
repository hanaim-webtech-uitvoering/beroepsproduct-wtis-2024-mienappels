<?php
function showOrder($order){
    global $db;
    echo '<tr>';


    echo '<form action="./detail-personnel.php" method="post">';
    echo '<input type="hidden" name="orderid" value="' . $order['order_id'] . '">';
    echo '<td><input type="submit" value="' . $order['order_id'] . '"></td>';



    // echo '<td>' . $order['order_id'] . '</td>';



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