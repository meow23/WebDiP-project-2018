<?php
require("database.class.php");
if($_GET['idUser'] == "ajaxCheckUsername"){
    $username = $_GET["username"];

    $sql = "SELECT count(*) as number FROM  `Korisnik`  WHERE korisnicko_ime='".$username."'";

    $check = new Database();
    $check ->connectDB();

    $result = $check->sqlQuery($sql);
    $result = mysqli_fetch_assoc($result);
    echo"<users>";
    if($result['number']>0) echo "<unavailable>1</unavailable>";
    else echo "<unavailable>0</unavailable>";
    echo "</users>";

    $check->closeConnection();

}




