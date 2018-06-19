<?php
	
	require_once("database.class.php");

	if (isset($_POST['submitCategoryForm'])) {
		$firstName = $_POST['firstName'];
		$lastName = $_POST['lastName'];
		$address = $_POST['address'];
		$amount = $_POST['amount'];
		$productID = $_GET['id'];
		
		$sql = 'INSERT INTO narudzba VALUES (
			DEFAULT, "'.$firstName.'", "'.$lastName.'", "'.$address.'", "'.$amount.'", 0, '.$productID.'
		)';
		
		$result = new Database();
		$result->connectDB();
		$result->sqlQuery($sql);
		$result->closeConnection();
		
		header('location: ../proizvodpregled.php?id='.$productID.'&status=poslano');
	}
	
	function submitOrder($id) {
		$sql = 'UPDATE Narudzba SET potvrda = 1 WHERE idNarudzba = '.$id;
		
		$result = new Database();
		$result->connectDB();
		$result->sqlQuery($sql);

		$currentDate = date("Y-m-d", time());
		$currentTime = date("H:i");
		
		$sql = 'INSERT INTO Racun VALUES(DEFAULT, "'.$currentDate.'", NOW(), '.$id.')';
		
		$result->sqlQuery($sql);
		$result->closeConnection();
		header("location: popisnarudzbi.php");
	}

?>