<?php

	if (!isset($_GET['s']) || $_GET['s'] == "") {
		header("location: popisnarudzbi.php?s=1");
	}

	include("templates/header.php");
	include_once("database/fetchOrders.php");
	include_once("database/fetchProductData.php");
	
	$orderList = fetchAllOrders();
?>

<div class="main-body">

	<h1>Popis svih narudžbi</h1>
	
					
					<form method="POST" action="" enctype="multipart/form-data">
						<div class="form-input-sm">
						<label>Sortiraj prema nazivu:</label>
						<select type="select" name="order">
							<option value="asc">Uzlazno</option>
							<option value="desc">Silazno</option>
						</select>
						<button type="submit" name="sortField" class="button button-send">Sortiraj</button>
						</div>
					</form>
	
	<table class="table">
					<thead>
						<th>#</th>
						<th>Ime i prezime </th>
						<th>Adresa </th>
						<th>Proizvod</th>
						<th>Cijena</th>
						<th>Količina</th>
						<th>Popust</th>
						<th>Ukupno</th>
						<th>Akcije</th>
						
					</thead>
					<tbody>
						<?php
						while ($order = mysqli_fetch_assoc($orderList)) {
							echo('<tr>');
							echo('<td>'.$order["idNarudzba"].'</td>');
							echo('<td>'.$order["Ime"].' '.$order['Prezime'].' </td>');
							echo('<td>'.$order["Adresa"].' </td>');
							
							$product = fetchProductData($order["Proizvod_idProizvod"]);
							echo('<td>'.$product["nazivProizvoda"].'</td>');
							echo('<td>'.$product["cijenaProizvoda"].' kn</td>');
							echo('<td>'.$order["Kolicina"].' </td>');
							
							if ($product["Akcija_idAkcija"] != NULL) $discount = fetchProductDiscount($product['Akcija_idAkcija']);
							else $discount = 0;
							echo('<td>'.$discount.' %</td>');
							
							if ($discount > 0) {
								$price = $product["cijenaProizvoda"] * (1 - ($discount / 100)) * $order["Kolicina"];
							} else {
								$price = $product["cijenaProizvoda"] * $order["Kolicina"];
							}
							echo('<td>'.$price.' kn</td>');
							echo('<td>');
							if ($order['potvrda'] == 0) echo('<a role="button" class="button button-send" href="potvrdanarudzbe.php?id='.$order["idNarudzba"].'">Potvrdi</a> ');
							else echo('<a role="button" class="button button-send" href="pregledracuna.php?id='.$order["idNarudzba"].'">Pregled računa</a></td>');

							echo('</tr>');
						}
						?>
					</tbody>
				</table>
				<br><br>
				<?php
				$numberOfPages = countAllTableInserts();
                $limit = findLimit();
                $numberOfPages = ceil($numberOfPages / $limit);
					if ($numberOfPages > 1) {
						$page = $_GET['s'] - 1;
						if($page > 0) echo('<a class="page" href="popisnarudzbi.php?s='.$page.'">Prethodna</a>');
					}
					if ($numberOfPages > 1) {
						echo('<a class="page" href="popisnarudzbi.php?s=1">1</a>');
					}
					
					
					for ($i = 2; $i <= $numberOfPages; $i++) {
						$pageNumber = $i;
						echo('<a class="page" href="popisnarudzbi.php?s='.$pageNumber.'">'.$pageNumber.'</a>');
					}
					if ($numberOfPages > 1) {
						$page = $_GET['s'] + 1;
						if($page < $numberOfPages) echo('<a class="page" href="popisnarudzbi.php?s='.$page.'">Sljedeća</a>');
					}
					if ($numberOfPages > 1) {
						if($_GET['s'] != $numberOfPages) echo('<a class="page" href="popisnarudzbi.php?s='.$numberOfPages .'">Zadnja</a>');
					}
				
				?>
				<br> <br>

</div>

<?php

	include("templates/footer.php");

?>