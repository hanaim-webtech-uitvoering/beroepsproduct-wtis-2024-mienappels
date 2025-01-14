<?php

require_once 'db_connectie.php';
session_start();
global $db;
$db = maakVerbinding();
var_dump($_SESSION);
var_dump($_POST);


$username = $_POST['username'];



if($_SESSION['role'] == 'Client'){
    $query = 'select username from "User" where role = :role';
    $stmt = $db->prepare($query);
    $stmt->execute(['role' => 'Personnel']);
    $personnel = $stmt->fetchAll();
    $personnel_amount = sizeof($personnel);
    $random_personnel = rand(0, $personnel_amount - 1);
    $personnel_username = $personnel[$random_personnel]['username'];

    $query = 'insert into Pizza_order (client_username, client_name, personnel_username, datetime, status, address) values (:client_username, :client_name, :personnel_username, :datetime, :status, :address)';
    $data_array = [
        'client_username' => $username,
        'client_name' => $_SESSION['first_name'] . ' ' . $_SESSION['last_name'],
        'personnel_username' => $personnel_username,
        'datetime' => date('Y-m-d H:i:s'),
        'status' => '0',
        'address' => $_SESSION['address']
    ];
    $stmt = $db->prepare($query);
    $stmt->execute($data_array);
    



}





foreach ($_SESSION['cart'] as $product_name => $amount) {
    $query = 'SELECT * FROM Product WHERE name = :product_name';
    $stmt = $db->prepare($query);
    $stmt->execute(['product_name' => $product_name]);

}




?>