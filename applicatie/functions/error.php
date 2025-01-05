<?php


function checkError()
{
    if (isset($_GET['error'])) {
        if ($_GET['error'] == '403') {
            echo '<p>You tried to access restricted content.</p>';
        }
        if ($_GET['error'] == '400l') {
            echo '<p>Wrong username or password.</p>';
        }
        if ($_GET['error'] == '400c') {
            echo '<p>Something went wrong. Please try again.</p>';
        }
        if ($_GET['error'] == '400e') {
            echo '<p>Emails do not match.</p>';
        }
        if ($_GET['error'] == '400p') {
            echo '<p>Passwords do not match.</p>';
        }
    }
}





?>

