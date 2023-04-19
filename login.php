<!DOCTYPE html>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/input-validation/input-validation.php';
require_once __DIR__ . '/repo/client.repo.php';
require_once __DIR__ . '/includes/consolelog.inc.php';
require_once __DIR__ . '/includes/sesiune.inc.php';

session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST' and isset($_POST['submit']))
{
    // functia de validare returneaza adevarat daca validarea a avut succes, altfel returneaza fals
    $rezultatValidare = valideazaInputuriLogin();

    // daca validarea a avut succes
    if($rezultatValidare === true)
    {
        // atunci se verifica daca exista cu adevarat in baza de date un utilizator cu acelasi username si parola
        // $inputUsername = $_POST['username'];
        $inputUsername = htmlspecialchars($_POST['username']);
        consoleLog("input username: $inputUsername");
        // $inputParola = password_hash($_POST['parola'], PASSWORD_DEFAULT);
        $inputParola = $_POST['parola'];
        consoleLog("input parola: $inputParola");

        $repoClient = new ClientRepo();
        $clientLogat = $repoClient->verificaClient($inputUsername, $inputParola);

        if($clientLogat != null)
        {
            loginSession($clientLogat);

            consoleLog('input.php: login-ul a avut succes');
        }
        else
            consoleLog('input.php: login-ul nu a avut succes');
    }
    else
        consoleLog('validarea input-urilor de login nu a avut succes');
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
                        <label class="input-label">Username</label>
                        <input class="input-text1" type="text" name="username" placeholder="Username" >
                    </div>

                    <div class="input-column-item">
                        <input type="submit" name="submit" value="Trimite" class="input-submit"/>
                    </div>
                </div>

                <div class="input-column">
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