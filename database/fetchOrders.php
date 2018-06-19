<?php

	require_once("database.class.php");

function fetchAllOrders() {
    $sql = 'SELECT promijenjivaVrijednost FROM KonfiguracijaAplikacije WHERE idKonfiguracijaAplikacije = 4';
    $result = new Database();
    $result->connectDB();
    $number = $result->sqlQuery($sql);
    $number = mysqli_fetch_assoc($number);
    $limit = $number['promijenjivaVrijednost'];

    $order = "";
    $offset = ($_GET["s"] - 1) * $limit;
    if (isset($_POST["sortField"])) $order =' ORDER BY 2 '.$_POST["order"];
    $sql = 'SELECT * FROM Narudzba '.$order.' LIMIT '.$limit.' OFFSET '.$offset;


    $orderList = $result->sqlQuery($sql);
    $result->closeConnection();

    return $orderList;
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
	
	function countAllTableInserts() {
		$sql = 'SELECT COUNT(*) FROM Narudzba';
		$result = new Database();
        $result->connectDB();
        $count = $result->sqlQuery($sql);
        $result->closeConnection();
		$count = mysqli_fetch_assoc($count);
		return $count['COUNT(*)'];
	}

?>