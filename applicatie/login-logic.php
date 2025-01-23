<?php

require_once './functions/db_connectie.php';
session_start();
global $db;
$db = maakVerbinding();

if (isset($_POST['Login'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $query = 'SELECT * FROM "User" WHERE username = :username';
    $stmt = $db->prepare($query);
    $data_array = [
        'username' => $username
    ];
    $stmt->execute($data_array);
    $user = $stmt->fetch();
    if (password_verify($password, $user['password'])) {
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $user['role'];
        header('Location: index.php');
    } else {
        header('Location: login.php?error=400l');
    }
}

if (isset($_POST['Logout'])) {
    session_destroy();
    header('Location: index.php');
}

// header('Location: login.php?error=403');
//! als deze header uitgecomment wordt werkt de login niet meer


?>





