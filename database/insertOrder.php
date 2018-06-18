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

?>