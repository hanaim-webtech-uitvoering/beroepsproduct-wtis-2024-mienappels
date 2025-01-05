<?php

include './functions/error.php';
function getLoginForm()
{
    echo '<h1>Log in</h1>';
    echo '<form action="login-logic.php" method="post">';
    echo '<label for="username">Username:</label>';
    echo '<input type="text" id="username" name="username"></br>';
    echo '<label for="password">Password:</label>';
    echo '<input type="password" id="password" name="password">';
    echo '<input type="hidden" name="Login">';
    echo '</br><input type="submit" value="Login">';
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
    checkError();

    getLoginForm();
    ?>
</body>
</html>