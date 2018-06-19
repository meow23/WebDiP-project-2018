<?php

	include("templates/header.php");
	include("database/fetchProductData.php");
    include("database/database.class.php");
	

	if (!isset($_SESSION['userID'])) {
		if (!isset($_SESSION['seenProducts'])) {
			$_SESSION['seenProducts'] = array();
			array_push($_SESSION['seenProducts'], $_GET['id']);
		}
		$arrayList = array();
		$arrayList = $_SESSION['seenProducts'];
		$listOfSeenProducts = $_GET['id'];
		array_push($arrayList, $listOfSeenProducts);
		$_SESSION['seenProducts'] = $arrayList;
	}
	$productData = fetchProductData($_GET['id']);
    $vk = new Database();
    $vk->connectDB();
    $logWorkSql = "INSERT INTO dnevnikRada (vrijeme, radnja, Korisnik_idKorisnik) VALUES (NOW(), 'Pregled proizvoda', " . $_SESSION['userID'] . ")";
    $vk->sqlQuery($logWorkSql);
    $vk->closeConnection();


?>

<div class="main-body">

	<h1>Odabrani proizvod</h1>
	
	<div class="product-block">
		<p>Naziv proizvoda: </p>
		<h2><?php echo($productData['nazivProizvoda']) ?></h2>
		
		<p>Cijena: </p>
		<h2><?php echo($productData['cijenaProizvoda']) ?> kn</h2>
		
		<p>Dostupna količina: </p>
		<h2><?php echo($productData['kolicinaProizvoda']) ?></h2>
		
		<?php 
			if ($productData["Akcija_idAkcija"] != NULL) {
			?>
		<h2>Proizvod je na akciji!</h2>
			<?php } ?>
	</div>
	
	<h2> Naručivanje proizvoda </h2>
	
	
	<form method="POST" action="database/insertOrder.php?id=<?php echo($_GET['id']) ?>" enctype="multipart/form-data">
		<div class="form-input">
		<label>Ime:</label>
		<input type="text" required name="firstName" />
		
		</div>
		
		<div class="form-input">
		<label>Prezme:</label>
		<input type="text" required name="lastName" />
		
		</div>
		
		<div class="form-input">
		<label>Adresa:</label>
		<input type="text" required name="address" />
		
		</div>
		
		<div class="form-input">
		<label>Količina:</label>
		<input type="number" min="0" max="<?php echo($productData['kolicinaProizvoda']) ?>" required name="amount" />
		
		</div>
		
		<button type="submit" name="submitCategoryForm" class="button button-send">Pošalji narudžbu</button>
		
	</form>
	
	<br>
	<?php

    if (isset($_SESSION['userRole']) && $_SESSION['userRole'] > 2) {
        echo('<h4><a href="povijestproizvoda.php">Povijest pregledanih proizvoda</a></h4>');
    }

    ?>


</div>

<?php

	include("templates/footer.php")

?>