<!DOCTYPE html>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

?>

<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT School curs PHP: tema curs 10</title>
    <link rel="stylesheet" type="text/css" href="./styles/navbar.css"  />
    <link rel="stylesheet" type="text/css" href="./styles/footer.css"  />
    <link rel="stylesheet" type="text/css" href="./styles/general.css"  />
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous"> -->
</head>

<body style="padding: 25px;">
    <?php require('./templates/navbar.template.php') ?>
    <?php require('./templates/footer.template.php') ?>
</body>

</html>