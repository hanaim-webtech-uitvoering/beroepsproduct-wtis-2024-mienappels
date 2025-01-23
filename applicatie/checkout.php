<?php
require_once './functions/db_connectie.php';
session_start();
global $db;
$db = maakVerbinding();
include './functions/error.php';
include './functions/header_footer.php';

function getCart()
{
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
        echo '<td>€' . $product['price'] . '</td>';
        echo '<td>€' . $product['price'] * $amount . '</td>';
        echo '<td>' . $amount . '</td>';
    }
    echo '<tr><td colspan="3">Total</td><td>' . $total . '</td></tr>';
    echo '</table>';
}

function checkLogIn()
{
    if (isset($_SESSION['username'])) {
    } elseif (!isset($_SESSION['username'])) {
        echo '<h1>Register</h1>';
        echo ' <a href="register.php">Register here</a>';
        echo '<h1>Login</h1>';
        echo '<a href="login.php">Login here</a>';
        echo '</br>';
        echo '</br>';
        echo '</br>';
        echo '</br>';
        echo '</br>';

        // echo '<div>or continue without logging in:</div>'; //* Zie line 78
    }
}


function placeOrder()
{
    global $db;

    // echo '<a href="checkout-logic.php">checkout</a>';
    echo '<form action="checkout-logic.php" method="post">';

    if (isset($_SESSION['role'])) {
        $query = 'select * from "User" where username = :username';
        $stmt = $db->prepare($query);
        $stmt->execute(['username' => $_SESSION['username']]);
        $user = $stmt->fetch();
        echo '<label for ="name">Name:</label>';
        echo '<input type="text" required name="name" value="' . $user['first_name'] . ' ' . $user['last_name'] . '">';
        echo '</br>';

        echo '<label for="fill">Address:</label>';

        // echo '<input type="text" name="address" placeholder="Address">';
        echo '<input type="text" required name="address" value="' . $user['address'] . '">';
        echo '</br>';
        echo '<input type="submit" name="checkout" value="Checkout">';
    }
    //  else { //* Code voor een implementatie zonder inloggen alleen de foreign key op username maakt dat nu lastig
    //     echo '<label for ="name">Name:</label>';
    //     echo '<input type="text" required  name="name" placeholder="Name">';
    //     echo '</br>';

    //     echo '<label for="fill">Address:</label>';
    //     echo '<input type="text" required name="address" placeholder="Address">';
    //     echo '</br>'; 
    //     echo '<input type="submit" name="checkout" value="Checkout">';

    // }








}



?>


    <?php
    getHeader('checkout');
    checkError();
    getCart();
    checkLogIn();
    placeOrder();
    getFooter();
    ?>

