<?php

require_once 'db_connectie.php';
session_start();
global $db;
$db = maakVerbinding();

if($_SESSION['role'] == 'Client'){
    header('Location: index.php?error=403');
}
if(!($_SESSION['role'] == 'Personnel')){
    header('Location: index.php?error=403');
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
    getLoggedInUser();
    getProducts();

    getCart();
    ?>
</body>
</html>