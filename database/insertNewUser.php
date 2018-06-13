<?php
require("database.class.php");



$name = $_POST["name-reg"];
$surname = $_POST["surname-reg"];
$username = $_POST["username-reg"];
$password = $_POST["password-reg"];
$password_validate = $_POST["password-valid"];
$email = $_POST["email-reg"];
date_default_timezone_set('Europe/Berlin');
$date = date('Y-m-d  G:i:s',time());

$sql = "INSERT INTO Korisnik(Uloge_idUloge, korisnicko_ime, lozinka, potvrdaLozinke, ime, prezime, email, datum_vrijeme_registracije, statusAktivan)".
        " VALUES ('2','$username','$password','$password_validate','$name','$surname','$email','$date',TRUE)";

$insertion = new Database();
$insertion->connectDB();
$insertion->sqlQuery($sql);
$insertion->closeConnection();

header("Location:https://barka.foi.hr/WebDiP/2017_projekti/WebDiP2017x138/");
