<!DOCTYPE html>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/input-validation/input-validation.php';
require_once __DIR__ . '/repo/client.repo.php';
require_once __DIR__ . '/includes/consolelog.inc.php';


if($_SERVER['REQUEST_METHOD'] === 'POST' and isset($_POST['submit']))
{
    // functia de validare returneaza un obiect de tip Client daca validarea a avut succes, atlfel returneaza nul
    $clientNou = valideazaInputuriRegister();

    // daca validarea a avut succes
    if($clientNou != null)
    {
        // atunci se verifica daca mai exista deja in baza de date un utilizator cu acelasi email sau username
        $repoClient = new ClientRepo();
        if($repoClient->contineUsername($clientNou->username) === false and
            $repoClient->contineEmail($clientNou->email) === false)
        {
            $repoClient->adaugaClient($clientNou);
        }
        else
            consoleLog('username-ul sau email-ul exista deja in baza de date');
    }
    else
        consoleLog('client este nul, validarea nu a avut succes');
}
else
    consoleLog('nu s-a facut POST sau input-ul submit lipseste');

?>

<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT School curs PHP: tema curs 10</title>
    <link rel="stylesheet" type="text/css" href="./styles/navbar.css" />
    <link rel="stylesheet" type="text/css" href="./styles/footer.css" />
    <link rel="stylesheet" type="text/css" href="./styles/general.css" />
    <link rel="stylesheet" type="text/css" href="./styles/register.css" />
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous"> -->
</head>

<body>
    <?php require('./templates/navbar.template.php') ?>

    <div>
        <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
            <div class="input-column-container">
                <div class="input-column">
                    <div class="input-column-item">
                        <label class="input-label">Nume</label>
                        <input type="text" name="nume" placeholder="Numele" class="input-text">
                    </div class="input-column-item">

                    <div class="input-column-item">
                        <label class="input-label">Username</label>
                        <input type="text" name="username" placeholder="Username" class="input-text">
                    </div>

                    <div class="input-column-item">
                        <input type="submit" name="submit" value="Trimite" class="input-submit"/>
                    </div>
                </div>

                <div class="input-column">
                    <div class="input-column-item">
                        <label class="input-label">Email</label>
                        <input type="text" name="email" placeholder="Email" class="input-text">
                    </div>

                    <div class="input-column-item">
                        <label class="input-label">Parola</label>
                        <input type="password" name="parola" placeholder="Parola" class="input-text">
                    </div>
                </div>
            </div>
        </form>
    </div>

    <?php require('./templates/footer.template.php') ?>
</body>

</html>