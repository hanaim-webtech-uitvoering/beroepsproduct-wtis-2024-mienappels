<?php

function getHeader($pagetitle)
{

    echo <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>'$pagetitle'</title>
</head>
<body>
<a href="index.php">Home</a>
HTML;
}


function getFooter()
{

    echo <<<HTML
    <div>Footer:</div>
    <a href="privacyverklaring.php">Privacyverklaring</a>
</body>
</html>
HTML;
}
