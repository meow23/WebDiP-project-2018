<?php
include_once ('templates/header.php');

$addError;
if(!empty( $addError)){
    foreach ($addError as $k=>$v){
        echo "<p>$v</p>";
    }
}


?>
<div class="main-body">
    <br>
    <form id="newAdd" method="post" enctype="multipart/form-data">
        <div class="form-input">
            <label>Naziv oglasa: </label>
            <input type="text" id="nameAd" name="nameAd">
        </div>
        <br>
        <div class="form-input">
            <label>Datum početka: </label>
            <input type="text" id="startAd" name="startAd">
        </div>

        <br>
        <div class="form-input">
            <label>Vrsta oglasa:</label>
            <select id ='categoryAd' name='category'>
                <?php
                include ("database/categoryAd.php");
                ?>
            </select>

        </div>
        <br>
        <div class="form-input">
            <label>Opis oglasa: </label>
            <input type="text" id="descAd" name="descAd">
        </div>
        <br>
        <div class="form-input">
            <label>URL: </label>
            <input type="text" id="addURL" name="addURL">
        </div>
        <br>
        <div class="form-input">
            <label>Postavi sliku oglasa:</label>
            <input type="file" name="fileToUpload" id="addImage" >
        </div>
        <br>

        <button name="addAd" id="addAd" type="submit" value="1" class="button">Pošalji</button>
        <br>
        <br>
    </form>
</div>

<?php

require_once ('database/database.class.php');
if(isset($_POST['addAd'])){
    $addError = array();
    foreach ($_POST as $k=>$v){

        if(empty($v)){
            $addError[]="$k unesite!";
        }

    }
    if(!empty( $addError)){
        foreach ($addError as $k=>$v){
            echo "<p>$v</p>";
        }

    }
    else{




        $checkSql="SELECT trajanjeOglasaSati FROM VrstaOglasa WHERE idVrstaOglasa=".$_POST['category'];
        $logSql = "INSERT INTO dnevnikBaze(upit, Korisnik_idKorisnik) VALUES ('" .  $checkSql . "', " . $_SESSION['userID'] . ")";


        $checkDate=new Database();
        $checkDate->connectDB();
        $result=$checkDate->sqlQuery($checkSql);
        $checkDate->sqlQuery($logSql);
        $getEndDate=mysqli_fetch_assoc($result);
        $getEndDate = (int)$getEndDate['trajanjeOglasaSati'];
        $getDate = $_POST['startAd'];
        $getName = $_POST['nameAd'];
        $getDesc = $_POST['descAd'];
        $getCate = $_POST['category'];
        $getURL = $_POST['addURL'];
        $idOglas= $_GET['id'];


        $getDateEnding = date("Y-m-d H:i:s", strtotime("+$getEndDate hours", strtotime($getDate)));


        $korisnik = $_SESSION['userID'];




        $target_dir = "images/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $getImg = $_FILES["fileToUpload"]["name"];
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if file already exists
      /*  if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }*/

// Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
// Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                $sql = "UPDATE Oglasi SET naziv='".$getName."', datumPocetka='".$getDate."', datumZavrsetka='".$getDateEnding."', slika='".$getImg."', vrstaOglasa='".$getCate."', URLstranice='".$getURL."', opis='".$getDesc."' WHERE idOglas=$idOglas";
                $logSql = "INSERT INTO dnevnikBaze(upit, Korisnik_idKorisnik) VALUES ('" .  $sql . "', " . $_SESSION['userID'] . ")";
                $logWorkSql = "INSERT INTO dnevnikRada (vrijeme, radnja, Korisnik_idKorisnik) VALUES (NOW(), 'Azuriranje oglasa', " . $_SESSION['userID'] . ")";


                $checkDate->sqlQuery($sql);
                $checkDate->sqlQuery($logSql);
                $checkDate->sqlQuery($logWorkSql);
                $checkDate->closeConnection();

            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }

    }




}
require_once ("templates/footer.php");
?>