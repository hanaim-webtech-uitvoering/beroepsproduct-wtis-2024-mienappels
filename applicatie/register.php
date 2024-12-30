<?php


function createRegisterForm()
{
    echo '<h1>Register</h1>';
    echo '<form action="register.php" method="post">';
    echo '<label for="username">Username:</label>';
    echo '<input type="text" id="username" name="username"><br>';
    echo '<label for="first_name">First Name:</label>';
    echo '<input type="first_name" id="first_name" name="first_name"><br>';
    echo '<label for="last_name">Last Name:</label>';
    echo '<input type="last_name" id="last_name" name="last_name"><br>';
    echo '<label for="address">Address:</label>';
    echo '<input type="address" id="address" name="address"><br>';
    echo '<label for="email">Email:</label>';
    echo '<input type="email" id="email" name="email"><br>';
    echo '<label for="email-confirm">Confirm Email:</label>';
    echo '<input type="email" id="email-confirm" name="email-confirm"><br>';
    echo '<label for=password>Password:</label>';
    echo '<input type="password" id="password" name="password"><br>';
    echo '<label for=password-confirm>Confirm Password:</label>';
    echo '<input type="password" id="password-confirm" name="password-confirm"><br>';
    
 
    echo '<input type="submit" value="Register"><br>';
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
    createRegisterForm();
    ?>
</body>
</html>