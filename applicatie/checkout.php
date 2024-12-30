<?php
require_once 'db_connectie.php';
session_start();
global $db; 
$db = maakVerbinding();

function getCart() {
    global $db;
    $cart = $_SESSION['cart'];
    $total = 0;
    echo '<h1> Winkelmandje </h1>';

    echo '<table border="1">';
    echo '<tr><th>Product Name</th><th>Product Price</th><th>Amount</th><th>Total Price</th></tr>';
    foreach ($cart as $product_name => $amount) {
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
    }
    echo '<tr><td colspan="3">Total</td><td>' . $total . '</td></tr>';
    echo '</table>';
}

function checkLogIn()
{
    if (isset($_SESSION['username'])) {
        echo '<h1>Log in</h1>';
        echo '<form action="login.php" method="post">';
        echo '<label for="username">Username:</label>';
        echo '<input type="text" id="username" name="username">';
        echo '<label for="password">Password:</label>';
        echo '<input type="password" id="password"></label>';
        echo '<input type="submit" value="Log in">';
        echo '</form>';
    }
    elseif (!isset($_SESSION['username'])) {
        echo '<h1>Register</h1>';
        echo ' <a href="register.php">Register here</a>';
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
    <?php 
    getCart();
    checkLogIn();
    ?>
</body>
</html>