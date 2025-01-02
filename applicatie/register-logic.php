<?php

require_once 'db_connectie.php';
session_start();
global $db;
$db = maakVerbinding();

//! @todo check if user is reaching this page through the register form
if (!isset($_POST['Register'])){
    // $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; // https://stackoverflow.com/questions/6768793/get-the-full-url-in-php
    header('Location: register.php?error=403');
}

$username = htmlspecialchars(trim($_POST['username']));
$first_name = htmlspecialchars(trim($_POST['first_name']));
$last_name = htmlspecialchars(trim($_POST['last_name']));
$address = htmlspecialchars(trim($_POST['address']));
// $email = $_POST['email'];
// $email_confirm = $_POST['email-confirm'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
// $password_confirm = password_hash($_POST['password-confirm'], PASSWORD_DEFAULT);

// if ($email != $email_confirm) {
    // header('Location: register.php?error=400e');
// }

// if ($password != $password_confirm) {
    // header('Location: register.php?error=400p');
// }

$query = 'INSERT INTO "User" (username, first_name, last_name, address, password, role) VALUES (:username, :first_name, :last_name, :address, :password, :role)';

$data_array = [
    'username' => $username,
    'first_name' => $first_name,
    'last_name' => $last_name,
    'address' => $address,
    'password' => $password,
    'role' => 'Client'
];

$stmt = $db->prepare($query);
$succes = $stmt->execute($data_array);

if (!$succes) {
    header('Location: register.php?error=400c');
}


header('Location: login.php');

?>