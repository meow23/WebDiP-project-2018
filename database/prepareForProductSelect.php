<?php

	if (isset($_POST["submitCategoryForm"])) {
		if ($_POST["product"] != "") {
			header('location: ../proizvodi.php?s=1&kat='.$_POST["category"].'&naz='.$_POST["product"]);
		} else {
			header('location: ../proizvodi.php?s=1&kat='.$_POST["category"]);
		}
	} else {
		header("location: ../proizvodi.php");
	}

?>