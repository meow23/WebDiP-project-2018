<?php

	require("database.class.php");
	
	function getCategories() {
        $sql = 'SELECT idKategorije, naziv FROM Kategorija_Proizvoda';

        $result = new Database();
        $result->connectDB();
        $categoryList = $result->sqlQuery($sql);
        $result->closeConnection();

        return $categoryList;
    }

?>