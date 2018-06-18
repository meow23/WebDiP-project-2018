<?php

	include("templates/header.php");
	include("database/pushAllCategories.php");
	include("database/fetchProductListByCategoryThenNameIfPresent.php");
    error_reporting(E_ALL);
?>

<div class="main-body">

	<h1>Proizvodi</h1>

    <?php
    $categoryList = getCategories();
    ?>
	
	<form method="POST" action="database/prepareForProductSelect.php" enctype="multipart/form-data">
		<div class="form-input">
		<label>Odaberite kategoriju proizvoda:</label>
		<select type="select" name="category">
			<?php
            while ($list = mysqli_fetch_assoc($categoryList)) {

                ?>

                <option <?php if (isset($_GET["kat"]) && $list["idKategorije"] == $_GET["kat"]) echo(" selected ") ?>
                        value="<?php echo($list["idKategorije"]) ?>"><?php echo($list["naziv"]) ?></option>

                <?php
            }
			?>
		</select>
		
		</div>
		<div class="form-input">
			<label>Unesite naziv proizvoda (proizvoljno):</label>
			<input type="text" name="product" />
		</div>
		
		<button type="submit" name="submitCategoryForm" class="button button-send button-block">Pretraži</button>
		
	</form>
	
	<br>
	<br>
	
	<?php
		if (isset($productList)) {
	?>
				<h2>Lista traženih proizvoda</h2>
				
				<?php
					if ($productList->num_rows == 0) {
						echo('<h3>Pronađeno je 0 proizvoda :(</h3>');
					} else {
				?>
				
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
						<th>Naziv proizvoda</th>
						<th>Cijena</th>
						<th>Opis</th>
						<th>Dodatno</th>
					</thead>
					<tbody>
						<?php
						while ($product = $productList->fetch_assoc()) {
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
	<?php
					$numberOfPages = countAllTableInserts();
					$numberOfPages = ceil($numberOfPages / 10);
					for ($i = 1; $i <= $numberOfPages; $i++) {
						$pageNumber = $i;
						if (isset($_GET["naz"])) echo('<a class="page" href="proizvodi.php?s='.$pageNumber.'&kat='.$_GET["kat"].'&naz='.$_GET["naz"].'">'.$pageNumber.'</a>');
						else echo('<a class="page" href="proizvodi.php?s='.$pageNumber.'&kat='.$_GET["kat"].'">'.$pageNumber.'</a>');
					}
						
					}
		}
	?>
	<br>
	<br>
</div>

<?php

	include("templates/footer.php")

?>