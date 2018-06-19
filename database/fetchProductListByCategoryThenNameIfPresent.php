<?php

if (isset($_GET["s"]) && isset($_GET["kat"])) {
    require_once("database.class.php");

    $sql = 'SELECT promijenjivaVrijednost FROM KonfiguracijaAplikacije WHERE idKonfiguracijaAplikacije = 4';
    $result = new Database();
    $result->connectDB();
    $number = $result->sqlQuery($sql);
    $number = mysqli_fetch_assoc($number);
    $limit = $number['promijenjivaVrijednost'];

    $sql = "";
    $order = "";
    $offset = ($_GET["s"] - 1) * $limit;

    if (isset($_GET["naz"]) && $_GET["naz"] != "") {
        if (isset($_POST["sortField"])) $order =' ORDER BY 2 '.$_POST["order"];
        $sql = 'SELECT Proizvod.idProizvod,
						Proizvod.nazivProizvoda,
						Proizvod.cijenaProizvoda,
						Proizvod.Akcija_idAkcija
					FROM Proizvod_has_Kategorija_Proizvoda
						JOIN Proizvod ON Proizvod_has_Kategorija_Proizvoda.Proizvod_idProizvod = Proizvod.idProizvod
						JOIN Kategorija_Proizvoda ON Proizvod_has_Kategorija_Proizvoda.Kategorija_Proizvoda_idKategorije = Kategorija_Proizvoda.idKategorije
					WHERE Kategorija_Proizvoda.idKategorije = '.$_GET["kat"].
            '	AND Proizvod.nazivProizvoda LIKE "%'.$_GET["naz"].'%" '.$order.' LIMIT '.$limit.' OFFSET '.$offset;

    }

    else {
        if (isset($_POST["sortField"])) $order =' ORDER BY 2 '.$_POST["order"];
        $sql = '
					SELECT Proizvod.idProizvod,
						Proizvod.nazivProizvoda,
						Proizvod.cijenaProizvoda,
						Proizvod.Akcija_idAkcija
					FROM Proizvod_has_Kategorija_Proizvoda
						JOIN Proizvod ON Proizvod_has_Kategorija_Proizvoda.Proizvod_idProizvod = Proizvod.idProizvod	
						JOIN Kategorija_Proizvoda ON Proizvod_has_Kategorija_Proizvoda.Kategorija_Proizvoda_idKategorije = Kategorija_Proizvoda.idKategorije
					WHERE Kategorija_Proizvoda.idKategorije = '.$_GET["kat"].' '.$order.' LIMIT '.$limit.' OFFSET '.$offset;
    }

    $productList = $result->sqlQuery($sql);
    $result->closeConnection();

}

function countAllTableInserts() {
    $sql = "";
    if (isset($_GET["naz"]) && $_GET["naz"] != "") {
        $sql = 'SELECT COUNT(*)
					FROM Proizvod_has_Kategorija_Proizvoda
						JOIN Proizvod ON Proizvod_has_Kategorija_Proizvoda.Proizvod_idProizvod = Proizvod.idProizvod	
						JOIN Kategorija_Proizvoda ON Proizvod_has_Kategorija_Proizvoda.Kategorija_Proizvoda_idKategorije = Kategorija_Proizvoda.idKategorije
					WHERE Kategorija_Proizvoda.idKategorije = '.$_GET["kat"].
            '	AND Proizvod.nazivProizvoda LIKE "%'.$_GET["naz"].'%"';
    }

    else {
        $sql = 'SELECT COUNT(*)
					FROM Proizvod_has_Kategorija_Proizvoda
						JOIN Proizvod ON Proizvod_has_Kategorija_Proizvoda.Proizvod_idProizvod = Proizvod.idProizvod	
						JOIN Kategorija_Proizvoda ON Proizvod_has_Kategorija_Proizvoda.Kategorija_Proizvoda_idKategorije = Kategorija_Proizvoda.idKategorije
					WHERE Kategorija_Proizvoda.idKategorije = '.$_GET["kat"];
    }

    $result = new Database();
    $result->connectDB();
    $count = $result->sqlQuery($sql);
    $number = mysqli_fetch_assoc($count);
    $result->closeConnection();
    return $number["COUNT(*)"];

}

function findLimit() {
    $sql = 'SELECT promijenjivaVrijednost FROM KonfiguracijaAplikacije WHERE idKonfiguracijaAplikacije = 4';
    $result = new Database();
    $result->connectDB();
    $number = $result->sqlQuery($sql);
    $number = mysqli_fetch_assoc($number);
    $limit = $number['promijenjivaVrijednost'];
    return $limit;
}
?>