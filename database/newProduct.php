<?php

	require("database.class.php");
	
	if (isset($_POST['submitForm'])) {
		$category = $_POST['category'];
		$product = $_POST['product'];
		$price = $_POST['price'];
		$amount = $_POST['amount'];
		$discount = $_POST['discount'];

        $logWorkSql = "INSERT INTO dnevnikRada (vrijeme, radnja, Korisnik_idKorisnik) VALUES (NOW(), 'Dodavanje proizvoda', " . $_SESSION['userID'] . ")";
		
		$sql = 'INSERT INTO Proizvod VALUES (DEFAULT, "'.$product.'", "'.$price.'", '.$amount.', '.$discount.')';
        $logSql = "INSERT INTO dnevnikBaze(upit, Korisnik_idKorisnik) VALUES ('" .  $sql . "', " . $_SESSION['userID'] . ")";
		$result = new Database();
        $result->connectDB();
        $result->sqlQuery($sql);
        $result->sqlQuery($logSql);
        $result->sqlQuery($logWorkSql);
		
		$sql = 'SELECT idProizvod FROM Proizvod ORDER BY 1 DESC';
        $logSql = "INSERT INTO dnevnikBaze(upit, Korisnik_idKorisnik) VALUES ('" .  $sql . "', " . $_SESSION['userID'] . ")";
        $idProduct = $result->sqlQuery($sql);
        $result->sqlQuery($logSql);
        
		$idProduct = mysqli_fetch_assoc($idProduct);
		
		$sql = 'INSERT INTO Proizvod_has_Kategorija_Proizvoda VALUES('.$idProduct['idProizvod'].', '.$category.')';
        $logSql = "INSERT INTO dnevnikBaze(upit, Korisnik_idKorisnik) VALUES ('" .  $sql . "', " . $_SESSION['userID'] . ")";
		$result->sqlQuery($sql);
        $result->sqlQuery($logSql);
		$result->closeConnection();
	}
	
	if (isset($_POST['submitFormDiscount'])) {
		$discount = $_POST['discount'];
		$start = $_POST['ds'];
		$end = $_POST['de'];
		
		$sql = 'INSERT INTO Akcija VALUES(DEFAULT, '.$discount.', "'.$start.'", "'.$end.'")';
        $logSql = "INSERT INTO dnevnikBaze(upit, Korisnik_idKorisnik) VALUES ('" .  $sql . "', " . $_SESSION['userID'] . ")";
		
		$result = new Database();
        $result->connectDB();
        $result->sqlQuery($sql);
        $result->sqlQuery($logSql);
		$result->closeConnection();
	}
	
	function fetchCategoriesAssignedToModerator($user) {
		$sql = 'SELECT Kategorija_Proizvoda.naziv, Kategorija_Proizvoda.idKategorije
				FROM Korisnik_has_Kategorija_Proizvoda JOIN Kategorija_Proizvoda ON 
				Korisnik_has_Kategorija_Proizvoda.Kategorija_Proizvoda_idKategorije = Kategorija_Proizvoda.idKategorije
				JOIN Korisnik ON Korisnik_has_Kategorija_Proizvoda.Korisnik_idKorisnik = Korisnik.idKorisnik
				WHERE Korisnik.idKorisnik = '.$user;
        $logSql = "INSERT INTO dnevnikBaze(upit, Korisnik_idKorisnik) VALUES ('" .  $sql . "', " . $_SESSION['userID'] . ")";
				
		$result = new Database();
        $result->connectDB();
        $categoryList = $result->sqlQuery($sql);
        $result->sqlQuery($logSql);
        $result->closeConnection();

        return $categoryList;
	}
	
	function fetchActiveDiscounts() {
		$sql = 'SELECT Akcija.idAkcija, Akcija.postotak FROM Akcija
				WHERE NOW() BETWEEN Akcija.datumPocetka AND Akcija.datumKraja';
        $logSql = "INSERT INTO dnevnikBaze(upit, Korisnik_idKorisnik) VALUES ('" .  $sql . "', " . $_SESSION['userID'] . ")";
		$result = new Database();
        $result->connectDB();
        $discount = $result->sqlQuery($sql);
        $result->sqlQuery($logSql);
        $result->closeConnection();

        return $discount;
	}

?>