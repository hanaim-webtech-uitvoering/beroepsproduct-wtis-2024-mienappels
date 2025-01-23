<?php

function checkIfPersonnel()
{
    if ($_SESSION['role'] == 'Personnel') {
        return true;
    } else {
        return false;
    }
}

function checkIfClient()
{
    if ($_SESSION['role'] == 'Client') {
        return true;
    } else {
        return false;
    }
}
