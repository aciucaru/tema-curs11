<?php

require_once __DIR__ . '/../model/produs.php';
require_once __DIR__. '/../includes/consolelog.inc.php';

class ProdusRepo
{
    private $conn;

    public function __construct()
    {
        $servername = 'localhost';
        $username = 'root';
        $password = '';
        $dbname = 'tema11';

        $this->conn = mysqli_connect($servername, $username, $password, $dbname);

        if(!$this->conn)
        {
            consoleLog("ProdusRepo::construct: nu s-a putu realiza conexiunea la baza de date");
            die('Could not connect to database' . mysqli_connect_error());
        }
    }

    public function adaugaProdus(Produs $produs): int
    {
        $produsId = -1;

        if(isset($produs))
        {
            $query = "INSERT into produse (denumire, pret, bucati_stoc)
                        VALUES ($produs->denumire, $produs->pret, $produs->bucatiStoc)";

            $result = mysqli_query($this->conn, $query);
            $produsId = mysqli_insert_id($this->conn);
        }

        return $produsId;
    }

    public function iaProdus(int $id): ?Produs
    {
        consoleLog("ProdusRepo::iaProdus: inceput rularea");

        $query = "SELECT * from produse WHERE produs_id=$id;";
        $rezultat = mysqli_query($this->conn, $query);
        $numarRezultate = mysqli_num_rows($rezultat);

        if($numarRezultate === 1)
        {
            $dateProdus = mysqli_fetch_assoc($rezultat);

            $produs = new Produs(
                                    $dateProdus['produs_id'],
                                    $dateProdus['denumire'],
                                    $dateProdus['pret'],
                                    $dateProdus['bucati_stoc'],
                                );
            consoleLog("ProdusRepo::iaProdus: produs luat cu succes");
            return $produs;
        }
        else
        {
            consoleLog("ProdusRepo::iaProdus: produsul cu id $id nu a fost gasit in baza de date");
            return null;
        }
    }

    public function iaToateProdusele(): array
    {
        $sirProduse = [];

        $query = 'SELECT * from produse';
        $result = mysqli_query($this->conn, $query);

        $produsCurent = new Produs(-1, "", 0.0, 0);
        while($produs = mysqli_fetch_array($result))
        {
            $produsCurent = new Produs(
                                        $produs['produs_id'],
                                        $produs['denumire'],
                                        $produs['pret'],
                                        $produs['bucati_stoc'],
                                        );

            array_push($sirProduse, $produsCurent);
        }

        return $sirProduse;
    }
}

?>