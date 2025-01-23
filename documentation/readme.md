# Verslag risicoanalyse OWASP 10

## Tabel 1: SQL-injectie

| Risico | R1: SQL-injectie vanuit views met logincomponent. |
|--------|---------------------------------------------------|
| Aanvalstechniek | Broncodeinjectie: SQL. |
| Kans | Hoog: staat op nummer één van de OWASP Top 10 (A1:2017-Injection, z.d.). |
| Gevolg | Hoog: PHP-broncode die het SQL statement uitvoert heeft minstens de rechten om de hele gebruikerstabel uit te lezen. |

### Gevolgen van een doorbraak bij dit risico
Een succesvolle SQL-injectie-aanval kan leiden tot het uitlezen, wijzigen of verwijderen van gegevens in de database. Dit kan ernstige gevolgen hebben, zoals het lekken van gevoelige gebruikersinformatie, verlies van integriteit van de gegevens en mogelijke financiële schade.

### Beveiligingsmaatregelen
Om de applicatie te beveiligen tegen SQL-injectie, is het belangrijk om gebruik te maken van prepared statements en parameter binding. Hieronder een voorbeeld van hoe dit in de PHP-broncode is geïmplementeerd:

```php
// filepath: /applicatie/login-logic.php
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
?>