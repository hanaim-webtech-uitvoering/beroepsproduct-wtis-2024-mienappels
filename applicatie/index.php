<?php
require_once 'db_connectie.php';
session_start();
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
if (isset($_POST['add']) || isset($_POST['remove'])) {
    if ($_POST['amount'] != 0) {
        $amount = $_POST['amount'];
        $product_name = 0;
        $product_name = $_POST['product_name'];
        if (!isset($_SESSION['cart'][$product_name])) {
            $_SESSION['cart'][$product_name] = 0;
        }
        $_SESSION['cart'][$product_name] += $amount;
    } 
}

if (isset($_POST['empty'])) {
    $_SESSION['cart'] = [];
}

global $db; 
$db = maakVerbinding();

function getProducts() {
    global $db;
    $query = 'SELECT type_id FROM Product GROUP BY type_id';
    $data = $db->query($query);

    foreach ($data as $rij) {
        $type_id = $rij['type_id'];
        $query = 'SELECT * FROM Product WHERE type_id = :type_id';
        $stmt = $db->prepare($query);
        $stmt->execute(['type_id' => $type_id]);
        $products = $stmt->fetchAll();

        echo '<h1>Producten van type ' . $type_id . '</h1>';
        echo '<table border="1">';
        echo '<tr><th>Product Name</th><th>Product Price</th><th>Amount</th><th>Add</th></tr>';
        foreach ($products as $product) {
            echo '<tr>';
            echo '<form action="index.php" method="post">';
            echo '<td>' . $product['name'] . '</td>';
            echo '<td>' . $product['price'] . '</td>';
            echo '<td><input type="number" name="amount" value="0" min="0"></td>';
            echo '<input type="hidden" name="product_name" value="' . $product['name'] . '">';
            echo '<td><input type="submit" name="add" value="Add"></td>';
            echo '</form>'; 
            echo '</tr>';
        }
        //submit button
        
        echo '</table>';
        }
        echo '</form>';
}


function getCart() {
    global $db;
    $cart = $_SESSION['cart'];
    $total = 0;
    echo '<h1> Winkelmandje </h1>';

    echo '<table border="1">';
    echo '<tr><th>Product Name</th><th>Product Price</th><th>Amount</th><th>Total Price</th><th>Remove 1</th><th>Add 1</th></tr>';
    foreach ($cart as $product_name => $amount) {
        if($amount <= 0) {
            unset($_SESSION['cart'][$product_name]);
            continue;
        }
        $query = 'SELECT * FROM Product WHERE name = :product_name';
        $stmt = $db->prepare($query);
        $stmt->execute(['product_name' => $product_name]);
        $product = $stmt->fetch();
        $total += $product['price'] * $amount;
        echo '<tr>';
        echo '<td>' . $product_name . '</td>';
        echo '<td>' . $product['price'] . '</td>';
        echo '<td>' . $product['price'] * $amount . '</td>';
        echo '<td>' . $amount . '</td>';
        echo '<td><form action="index.php" method="post"><input type="submit" name="remove" value="Remove 1"><input type="hidden" name="amount" value="-1"><input type="hidden" name="product_name" value="' . $product_name . '"></form></td>';
        echo '<td><form action="index.php" method="post"><input type="submit" name="add" value="Add 1"><input type="hidden" name="amount" value="1"><input type="hidden" name="product_name" value="' . $product_name . '"></form></td>';
    }
    echo '<tr><td colspan="3">Total</td><td>' . $total . '</td></tr>';
    echo '</table>';
    echo '<form action="index.php" method="post">';
    echo '<input type="submit" name="empty" value="Empty Cart">';
    echo '</form>';
    echo '<form action="checkout.php" method="post">';
    echo '<input type="submit" name="checkout" value="Checkout">';
    echo '</form>';
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
    <?php
    getProducts();

    getCart();
    ?>
</body>
</html>