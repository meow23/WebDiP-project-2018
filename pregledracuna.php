<?php

	include("templates/header.php");
	include("database/fetchReceiptData.php");
    include_once("database/database.class.php");

	$reciept = fetchData($_GET['id']);

    $vk = new Database();
    $vk->connectDB();
    $logWorkSql = "INSERT INTO dnevnikRada (vrijeme, radnja, Korisnik_idKorisnik) VALUES (NOW(), 'Pregled racuna', " . $_SESSION['userID'] . ")";
    $vk->sqlQuery($logWorkSql);
    $vk->closeConnection();

?>

<div class="main-body">

	<h1>Račun broj: <?php echo($reciept["idRacun"]) ?></h1>
	
	<h3>Podaci o kupcu</h3>
	<table class="table">
		<thead>
			<tr>
				<th>Ime</th>
				<th>Prezime</th>
				<th>Adresa</th>
			</tr>
		</thead>
		<tbody>
			<tr>
			<?php
				$customer = fetchCustomerData($_GET['id']);
				echo('<td>'.$customer['Ime'].'</td>');
				echo('<td>'.$customer['Prezime'].'</td>');
				echo('<td>'.$customer['Adresa'].'</td>');
			?>
			</tr>
		</tbody>
	</table>
	<h3>Podaci o naručenom proizvodu</h3>
	<?php 
		$productData = fetchProductData($reciept["idRacun"]);
		echo('<p>Naziv proizvoda: <b>'.$productData['nazivProizvoda'].'</b></p>');
		echo('<p>Cijena proizvoda: <b>'.$productData['cijenaProizvoda'].' kn</b></p>');
		echo('<p>Narucena količina proizvoda: <b>'.$productData['Kolicina'].'</b></p>');
		
		if ($productData['Akcija_idAkcija'] != NULL) {
			$discount = fetchProductDiscount($productData['Akcija_idAkcija']);
			echo('<p>Popust: <b>'.$discount.'%</b></p>');
			
			$price = $productData["cijenaProizvoda"] * (1 - ($discount / 100)) * $productData["Kolicina"];
			echo('<h2>Cijena računa: '.$price.' kn</h2>');
		} else {
			$price = $productData["cijenaProizvoda"] * $productData["Kolicina"];
			echo('<h2>Cijena računa: '.$price.' kn</h2>');
		}
	?>
</div>

<?php

	include("templates/footer.php");

?>