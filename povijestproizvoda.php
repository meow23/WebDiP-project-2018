<?php

	include("templates/header.php");
	include("database/fetchProductData.php");

	$productHistoryList = array();
	$productHistoryList = array_unique($_SESSION['seenProducts']);
	
?>

<div class="main-body">
	<h1>Povijest pregledanih proizvoda: </h1>
	
		<table class="table">
					<thead>
						<th>Naziv proizvoda</th>
						<th>Cijena</th>
						<th>Opis</th>
						<th>Dodatno</th>
					</thead>
					<tbody>
						<?php
						foreach ($productHistoryList as $id) {
							$product = fetchProductData($id);
							echo('<tr>');
							echo('<td>'.$product["nazivProizvoda"].'</td>');
							echo('<td>'.$product["cijenaProizvoda"].' kn </td>');
							if ($product["Akcija_idAkcija"] != NULL) {
								echo('<td>Proizvod je na akciji.</td>');
							} else {
								echo('<td></td>');
							}
							echo('<td><a href="proizvodpregled.php?id='.$product["idProizvod"].'">Pregled proizvoda</a></td>');
							echo('</tr>');
						}
						?>
					</tbody>
				</table>
	
	<br>
	
</div>

<?php

	include("templates/footer.php")

?>