<?php
require_once './functions/db_connectie.php';
include './functions/error.php';
include './functions/header_footer.php';


session_start();
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
if (isset($_POST['add']) || isset($_POST['remove'])) {
    if ($_POST['amount'] != 0) {
        $amount = $_POST['amount'];
        $product_name = 0;
        $product_name = htmlspecialchars($_POST['product_name']);
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

        echo '<h1> Product type:' . $type_id . '</h1>';
        echo '<table border="1">';
        echo '<tr><th>Product Name</th><th>Product Price</th><th>Amount</th><th>Add</th></tr>';
        foreach ($products as $product) {
            echo '<tr>';
            echo '<form action="index.php" method="post">';
            echo '<td>' . $product['name'] . '</td>';
            echo '<td>€' . $product['price'] . '</td>';
            echo '<td><input type="number" name="amount" value="0" min="0"></td>';
            echo '<input type="hidden" name="product_name" value="' . $product['name'] . '">';
            echo '<td><input type="submit" name="add" value="Add"></td>';
            echo '</form>'; 
            echo '</tr>';
        }
        
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
        echo '<td>€' . $product['price'] . '</td>';
        echo '<td>€' . $product['price'] * $amount . '</td>';
        echo '<td>' . $amount . '</td>';
        echo '<td><form action="index.php" method="post"><input type="submit" name="remove" value="Remove 1"><input type="hidden" name="amount" value="-1"><input type="hidden" name="product_name" value="' . $product_name . '"></form></td>';
        echo '<td><form action="index.php" method="post"><input type="submit" name="add" value="Add 1"><input type="hidden" name="amount" value="1"><input type="hidden" name="product_name" value="' . $product_name . '"></form></td>';
    }
    echo '<tr><td colspan="3">Total</td><td>€' . $total . '</td></tr>';
    echo '</table>';
    echo '<form action="index.php" method="post">';
    echo '<input type="submit" name="empty" value="Empty Cart">';
    echo '</form>';
    echo '<form action="checkout.php" method="post">';
    echo '<input type="submit" name="checkout" value="Checkout">';
    echo '</form>';
}

function getLoggedInUser()
{
    if (isset($_SESSION['username'])) {
        echo '<h1>Ingelogd als: ' . $_SESSION['username'] . '</h1>';
        echo '<form action="login-logic.php" method="post">';
        echo '<input type="hidden" name="Logout">';
        echo '<input type="submit" name="Logout" value="Logout">';
        echo '</form>';

        if($_SESSION['role'] == 'Personnel') {
            echo '<h1>Personnel</h1>';
            echo '<a href="Personnel.php">Personell page</a>';
        }

        if($_SESSION['role'] == 'Client') {
            echo '<h1>Profile</h1>';
            echo '<a href="profiel.php">Profile Page</a>';
        }


    }elseif (!isset($_SESSION['username'])) {
        echo '<h1>Register</h1>';
        echo ' <a href="register.php">Register here</a>';
        echo '<h1>Login</h1>';
        echo '<a href="login.php">Login here</a>';
    } 
}


// function checkError()
// {
//     if (isset($_GET['error'])) {
//         if ($_GET['error'] == '403') {
//             echo '<p>You tried to access restricted content.</p>';
//         }
//         if ($_GET['error'] == '400l') {
//             echo '<p>Wrong username or password.</p>';
//         }
//         if ($_GET['error'] == '400c') {
//             echo '<p>Something went wrong. Please try again.</p>';
//         }
//     }
// }


?>





    <?php
        getHeader("Home");

    checkError();
    getLoggedInUser();
    getProducts();

    getCart();
    getFooter();

    ?>
