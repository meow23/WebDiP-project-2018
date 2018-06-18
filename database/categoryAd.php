<?php
require("database.class.php");

//$category = $_POST['categoryAd'];


$sql = "SELECT * FROM VrstaOglasa";

$catch = new Database();
$catch->connectDB();
$result = $catch->sqlQuery($sql);

//list($id,$naziv,$brzina,$lokacija,$trajanje,$cijena)
//echo "<select id ='categoryAd' name='category[]'>";
   while($r = mysqli_fetch_array($result)){
        echo"<option value='".$r['idVrstaOglasa']."'>".$r['naziv']."</option>";
   }
//echo"</select>";
foreach($_POST['category'] as $selected){
    echo "Bzina izmjene: ".$selected['brzinaIzmjeneSec'];
}

  // $sqlDetail = "SELECT * FROM VrstaOglasa WHERE idVrstaOglasa='".$prikaz['idVrastaOglasa']."'";


  // echo "Brzina izmjene: ".$r['brzinaIzmjeneSec'];
$catch->closeConnection();



//header("Location:https://barka.foi.hr/WebDiP/2017_projekti/WebDiP2017x138/index.php");
//header("Location:https://barka.foi.hr/WebDiP/2017_projekti/WebDiP2017x138/index.php");