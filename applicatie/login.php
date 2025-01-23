<?php

include './functions/error.php';
include './functions/header_footer.php';

function getLoginForm()
{
    echo '<h1>Log in</h1>';
    echo '<form action="login-logic.php" method="post">';
    echo '<label for="username">Username:</label>';
    echo '<input type="text" id="username" name="username" required ></br>';
    echo '<label for="password">Password:</label>';
    echo '<input type="password" id="password" name="password" required >';
    echo '<input type="hidden" name="Login" required >';
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







    <?php
        getHeader('Login');

    checkError();

    getLoginForm();
    getFooter();

    ?>
