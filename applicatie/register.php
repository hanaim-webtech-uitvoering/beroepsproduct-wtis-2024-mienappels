<?php

require_once './functions/db_connectie.php';
session_start();
global $db;
$db = maakVerbinding();
include './functions/error.php';
include './functions/header_footer.php';


// function checkError()
// {
//     if (isset($_GET['error'])) {
//         if ($_GET['error'] == '403') {
//             echo '<p>You tried to access restricted content.</p>';
//         }
//         if ($_GET['error'] == '400e') {
//             echo '<p>Emails do not match.</p>';
//         }
//         if ($_GET['error'] == '400p') {
//             echo '<p>Passwords do not match.</p>';
//         }
//         if ($_GET['error'] == '400c') {
//             echo '<p>Something went wrong. Please try again.</p>';
//         }
//     }
// }

function createRegisterForm()
{
    echo '<h1>Register</h1>';
    echo '<form action="register-logic.php" method="post">';
    echo '<label for="username">Username:</label>';
    echo '<input type="text" id="username" name="username"><br>';
    echo '<label for="first_name">First Name:</label>';
    echo '<input type="first_name" id="first_name" name="first_name"><br>';
    echo '<label for="last_name">Last Name:</label>';
    echo '<input type="last_name" id="last_name" name="last_name"><br>';
    echo '<label for="address">Address:</label>';
    echo '<input type="address" id="address" name="address"><br>';
    // echo '<label for="email">Email:</label>';
    // echo '<input type="email" id="email" name="email"><br>';
    // echo '<label for="email-confirm">Confirm Email:</label>';
    // echo '<input type="email" id="email-confirm" name="email-confirm"><br>';
    echo '<label for=password>Password:</label>';
    echo '<input type="password" id="password" minlength="8" name="password"><br>';
    // echo '<label for=password-confirm>Confirm Password:</label>';
    // echo '<input type="password" id="password-confirm" minlength="8" name="password-confirm"><br>';

    echo '<input type="hidden" name="Register">';

    echo '<input type="submit" value="register"><br>';
}

?>



    <?php
    getHeader('Register');

    checkError();
    createRegisterForm();
    getFooter();

    ?>
