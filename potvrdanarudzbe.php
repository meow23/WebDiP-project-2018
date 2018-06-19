<?php

	session_start();

	include("database/insertOrder.php");
	submitOrder($_GET['id']);

?>