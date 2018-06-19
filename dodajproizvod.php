<?php

	include("templates/header.php");
	include("database/newProduct.php");

?>

<div class="main-body">

	<h1>Dodaj novi proizvod</h1>

	<form method="POST" enctype="multipart/form-data" action="<?php echo($_SERVER['PHP_SELF']) ?>">
		<div class="form-input">
		<label>Odaberite kategoriju: </label>
			<select name="category">
				<?php 
					$categoryList = fetchCategoriesAssignedToModerator($_SESSION['userID']);
					
            while ($list = mysqli_fetch_assoc($categoryList)) {

                ?>

                <option value="<?php echo($list["idKategorije"]) ?>"><?php echo($list["naziv"]) ?></option>

                <?php
            }
			?> 
				?>
			</select></div>
					<div class="form-input">
			<label>Unesite naziv proizvoda:</label>
			<input type="text" required name="product" />
		</div>
		<div class="form-input">
			<label>Unesite cijenu proizvoda:</label>
			<input type="double" required name="price" />
		</div>
		<div class="form-input">
			<label>Unesite količinu proizvoda:</label>
			<input type="number" required name="amount" />
		</div>
		<div class="form-input">
			<label>Unesite akciju:</label>
			<select name="discount">
				<?php
					$discount = fetchActiveDiscounts();
					echo('<option value="NULL">0% </option>');
					while ($dList = mysqli_fetch_assoc($discount)) {
						
						echo('<option value="'.$dList['idAkcija'].'">'.$dList['postotak'].'% </option>');
					}
				
				?>
			</select>
		</div>
		<button type="submit" name="submitForm" class="button button-send button-block">Dodaj novi proizvod</button>
	</form>
	
	<h2>Dodaj novi popust</h2>
	
	<form method="POST" enctype="multipart/form-data" action="<?php echo($_SERVER['PHP_SELF']) ?>">
		<div class="form-input">
			<label>Unesite postotak sniženja:</label>
			<input type="double" required name="discount" />
		</div>
		<div class="form-input">
			<label>Unesite datum početka:</label>
			<input type="date" required name="ds" />
		</div>
		<div class="form-input">
			<label>Unesite datum kraja:</label>
			<input type="date" required name="de" />
		</div>
		<button type="submit" name="submitFormDiscount" class="button button-send button-block">Dodaj novi popust</button>
	</form>
	
</div>

<?php

	include("templates/footer.php");

?>