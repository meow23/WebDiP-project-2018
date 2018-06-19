<?php
require ("templates/header.php");

include ("database/database.class.php");
?>
<form id="lostPass" method="post">

    <label> Unesite novu lozinku:</label>
    <input id="lozinka" type="password" maxlength="30" name="resetpass">
    <br>
    <label> Unesite novu lozinku ponovo:</label>
    <input id="lozinkaP" type="password" maxlength="30" name="resetpassC">
    <br>

<button id="sendEmail"  name = "btnSend" value="sendEmail" type="submit" >Pošalji</button>
</form>
<?php


if(isset($_POST["resetpass"])&&isset($_POST["resetpassC"])){
    $username = $_POST["resetkorime"];
    $password = $_POST["resetpass"];
    $password_val = $_POST["resetpassC"];

    $sql = "UPDATE Korisnik SET lozinka='".$password."', potvrdaLozinke='".$password_val."' WHERE korisnicko_ime='".$username."'";
    $logSql = "INSERT INTO dnevnikBaze(upit, Korisnik_idKorisnik) VALUES ('" .  $sql . "', " . $_SESSION['userID'] . ")";


    $reset = new Database();
    $reset ->connectDB();
    $result = $reset->sqlQuery($sql);
    $reset->sqlQuery($logSql);
    echo "Lozinka promjenjena!";

}
else echo"Provjeri unose!";

require ("templates/footer.php");
?>
