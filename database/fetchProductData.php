<?php

	require_once("database.class.php");
	
	function fetchProductData($id) {
		$sql = "SELECT * FROM Proizvod WHERE idProizvod = ".$id;
		$result = new Database();
		$result->connectDB();
		$productData = $result->sqlQuery($sql);
		$result->closeConnection();
		
		return $productData->fetch_assoc();
	}

?>