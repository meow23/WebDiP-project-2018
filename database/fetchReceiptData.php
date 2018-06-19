<?php

	require("database/database.class.php");
	
	function fetchData($id) {
		$sql = 'SELECT * FROM Racun WHERE Narudzba_idNarudzba = '.$id;
		
		$result = new Database();
        $result->connectDB();
        $reciept = $result->sqlQuery($sql);
        $result->closeConnection();
		
		return mysqli_fetch_assoc($reciept);
	}
	
	function fetchCustomerData($id) {
		$sql = 'SELECT Ime, Prezime, Adresa FROM Narudzba WHERE idNarudzba = '.$id;
		
		$result = new Database();
        $result->connectDB();
        $reciept = $result->sqlQuery($sql);
        $result->closeConnection();
		
		return mysqli_fetch_assoc($reciept);
	}
	
	function fetchProductData($id) {
		$sql = 'SELECT Proizvod.nazivProizvoda, Proizvod.cijenaProizvoda, Narudzba.Kolicina, Proizvod.Akcija_idAkcija
		FROM Racun   JOIN Narudzba ON Racun.Narudzba_idNarudzba = Narudzba.idNarudzba
		JOIN Proizvod ON Proizvod.idProizvod = Narudzba.Proizvod_idProizvod
		WHERE Racun.idRacun = ' . $id;

		$result = new Database();
        $result->connectDB();
        $reciept = $result->sqlQuery($sql);
        $result->closeConnection();

		
		return mysqli_fetch_assoc($reciept);
	}
	
	function fetchProductDiscount($discountID) {
		$sql = 'SELECT postotak, datumKraja, datumPocetka FROM Akcija WHERE idAkcija = '.$discountID;
		
		$result = new Database();
        $result->connectDB();
        $discount = $result->sqlQuery($sql);
        $result->closeConnection();
		
		$discount = mysqli_fetch_assoc($discount);
		#$now = time();
		
		if (time() > strtotime($discount['datumKraja'])) return 0;
		else return $discount["postotak"];
	}

?>