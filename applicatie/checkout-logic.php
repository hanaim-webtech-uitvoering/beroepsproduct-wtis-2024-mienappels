<?php

require_once './functions/db_connectie.php';
session_start();
global $db;
$db = maakVerbinding();
var_dump($_SESSION);
var_dump($_POST);


$username = htmlspecialchars($_POST['name']);
$address = htmlspecialchars($_POST['address']);




global $order_id;

if (!isset($_POST['checkout'])) {
    header('location: checkout.php?error=403');
}


// if($_SESSION['role'] == 'Client'){



// Dit is voor het random selecteren van een personeelslid
$query = 'select username from "User" where role = :role';
$stmt = $db->prepare($query);
$stmt->execute(['role' => 'Personnel']);
$personnel = $stmt->fetchAll();
$personnel_amount = sizeof($personnel);
$random_personnel = rand(0, $personnel_amount - 1);
$personnel_username = $personnel[$random_personnel]['username'];
//

/* //* Onafgemaakte code voor een implementatie zonder inloggen alleen de foreign key op username maakt dat nu lastig
try {

    $query = 'SELECT name FROM "User" WHERE username = :username';
    $stmt = $db->prepare($query);


    if(isset($_SESSION['username'])) {
        $stmt->execute(['username' => $_SESSION['username']]);

    } else {
        $stmt->execute(['username' => $username]);

    }
    
    
    $client = $stmt->fetch();
    $client_name = $client['first_name'] . ' ' . $client['last_name'];
    
} catch (Exception $e) {
    $client_name = $username;
}
*/

$query = 'SELECT * FROM "User" WHERE username = :username';
$stmt = $db->prepare($query);
$stmt->execute(['username' => $_SESSION['username']]);
$client = $stmt->fetch();
$client_name = $client['first_name'] . ' ' . $client['last_name'];


$query = 'insert into Pizza_order (client_username, client_name, personnel_username, datetime, status, address) values (:client_username, :client_name, :personnel_username, :datetime, :status, :address)';
$data_array = [
    'client_username' => $_SESSION['username'],
    'client_name' => $client_name,
    'personnel_username' => $personnel_username,
    'datetime' => date('Y-m-d H:i:s'),
    'status' => '0',
    'address' => $address
];


$stmt = $db->prepare($query);
$stmt->execute($data_array);
global $order_id;
$order_id = $db->lastInsertId(); // https://www.php.net/manual/en/pdo.lastinsertid.php
// }

foreach ($_SESSION['cart'] as $product_name => $amount) {
    $query = 'SELECT * FROM Product WHERE name = :product_name';
    $stmt = $db->prepare($query);
    $stmt->execute(['product_name' => $product_name]);
    $product = $stmt->fetch();
    global $order_id;

    $query = 'insert into Pizza_order_product (order_id, product_name, quantity) values (:order_id, :product_name, :amount)';
    $data_array = [
        'order_id' => $order_id,
        'product_name' => $product_name,
        'amount' => $amount
    ];
    $stmt = $db->prepare($query);
    $stmt->execute($data_array);
}

if (isset($_SESSION['cart'])) {
    unset($_SESSION['cart']);
}

if ($_SESSION['role'] == 'Client') {
    header('Location: profiel.php');
} else {
    header('Location: Personnel.php');
}
