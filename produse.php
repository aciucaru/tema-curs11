<!DOCTYPE html>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/input-validation/input-validation.php';
require_once __DIR__ . '/repo/produs.repo.php';
require_once __DIR__ . '/includes/consolelog.inc.php';

session_start();

$repoProduse = new ProdusRepo();
$sirProduse = $repoProduse->iaToateProdusele();

if($_SERVER['REQUEST_METHOD'] === 'POST' and isset($_POST['submit']) and isset($_POST['produs_id']))
{
    $idProdus = $_POST['produs_id'];

    if(isset($_SESSION['cos']))
        array_push($_SESSION['cos'], $_POST);
    else
    {
        $_SESSION['cos'] = array();
        array_push($_SESSION['cos'], $_POST);
    }
    consoleLog("adaugat produs in cos: id: $idProdus");
}

?>

<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT School curs PHP: tema curs 10</title>
    <link rel="stylesheet" type="text/css" href="./styles/navbar.css" />
    <link rel="stylesheet" type="text/css" href="./styles/footer.css" />
    <link rel="stylesheet" type="text/css" href="./styles/produse.css" />
    <link rel="stylesheet" type="text/css" href="./styles/general.css" />
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous"> -->
</head>

<body>
    <?php require('./templates/navbar.template.php') ?>

    <div class="container-produse">
        <?php foreach($sirProduse as $produs): ?>
            <div class="item-produs">
                <div class="element-item element-denumire">
                    <div>Denumire</div>
                    <div> <?php echo $produs->denumire ?> </div>
                </div>

                <div class="element-item element-pret">
                    <div>Pret</div>
                    <div> <?php echo $produs->pret ?> RON </div>
                </div>

                <div class="element-item element-stoc">
                    <div>Stoc</div>
                    <div> <?php echo $produs->bucatiStoc ?> buc. </div>
                </div>

                <div class="element-item element-adauga">
                    <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" name="produs_id" value = "<?php echo $produs->getId() ?>"/>
                        <input type="submit" name="submit" value="" class="input-adauga"/>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php require('./templates/footer.template.php') ?>
</body>

</html>