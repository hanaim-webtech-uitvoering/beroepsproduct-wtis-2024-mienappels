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
        
    }
    elseif (!isset($_SESSION['username'])) {
        echo '<h1>Register</h1>';
        echo ' <a href="register.php">Register here</a>';
        echo '<h1>Login</h1>';
        echo '<a href="login.php">Login here</a>';
        echo '</br>';
        echo '</br>';
        echo '</br>';
        echo '</br>';
        echo '</br>';

        echo '<div>or continue without logging in:</div>';
    } 

    
}


function placeOrder(){
    global $db;

    // echo '<a href="checkout-logic.php">checkout</a>';
    echo '<form action="checkout-logic.php" method="post">';

    if(isset($_SESSION['role']) && ($_SESSION['role'] == 'Client')){
        $query = 'select * from "User" where username = :username';
        $stmt = $db->prepare($query);
        $stmt->execute(['username' => $_SESSION['username']]);
        $user = $stmt->fetch();
        echo '<label for ="name">Name:</label>';
        echo '<input type="text" required name="name" value="' . $user['first_name'] . ' ' . $user['last_name'] . '">';
        echo '</br>';

        echo '<label for="fill">Address zelf invullen:</label>';
        echo '<input type="radio" required id="fill" name="address" value="work">';
        echo '<input type="text" name="address" placeholder="Address">';
        echo '</br>';
        echo '<label for="notfill">Address gebruiken van account:</label>';
        echo '<input type="radio" required  id="notfill"name="address" value="home">';
        echo '</br>';
        echo '<input type="submit" name="checkout" value="Checkout">';

    } else {
        echo '<label for ="name">Name:</label>';
        echo '<input type="text" required  name="name" placeholder="Name">';
        echo '</br>';

        echo '<label for="fill">Address:</label>';
        echo '<input type="text" required name="address" placeholder="Address">';
        echo '</br>'; 
        echo '<input type="submit" name="checkout" value="Checkout">';

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
    getCart();
    checkLogIn();
    placeOrder();
    ?>
</body>
</html>