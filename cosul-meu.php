<!DOCTYPE html>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/repo/produs.repo.php';
require_once __DIR__ . '/includes/shopping-cart.inc.php';
require_once __DIR__ . '/includes/consolelog.inc.php';

session_start();

$sirProduseCos = iaProduseleDinCos();
$totalCos = calculeazaTotalCos();

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

    <div class="container-principal">
        <div class="container-produse">
            <?php foreach($sirProduseCos as $produs): ?>
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
                </div>
            <?php endforeach; ?>
        </div>
        <div class="container-total-cos">
            <div class="total-cos">
                <div class="total">
                    Total: <?php echo $totalCos ?> RON
                </div>
            </div>
        </div>
    </div>

    <?php require('./templates/footer.template.php') ?>
</body>

</html>