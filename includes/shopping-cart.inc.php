<?php

require_once __DIR__ . '/../repo/produs.repo.php';

function valideazaSiAdaugaInCos()
{
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
}

function iaProduseleDinCos(): array
{
    $sirProduseCos = [];

    $repoProduse = new ProdusRepo();

    if(isset($_SESSION['cos']))
    {
        $idCurent = -1;
        $produsCurent = new Produs(-1, "", 0.0, 0);
        foreach($_SESSION['cos'] as $produs)
        {
            $idCurent = htmlspecialchars($produs['produs_id']);
            $produsCurent = $repoProduse->iaProdus($idCurent);
            array_push($sirProduseCos, $produsCurent);
        }
    }

    return $sirProduseCos;
}

function calculeazaTotalCos(): float
{
    $pretTotal = 0.0;

    $produseCos = iaProduseleDinCos();

    foreach($produseCos as $produs)
    {
        $pretTotal += $produs->pret;
    }

    return $pretTotal;
}

?>