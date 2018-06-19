<?php
require("templates/header.php");
include("database/database.class.php");
?>
<div class="main-body">
    <form id="lostPass" method="post">
        <div class="form-input">
            <label> Unesite e-mail adresu:</label>
            <input id="email" type="email" maxlength="30" name="emailReset">
            <br>
            <button id="sendEmail" name="btnSend" value="sendEmail" type="submit" class="button">Pošalji</button>
        </div>

    </form>
</div>

<?php
if (isset($_POST['emailReset'])) {

    $email = $_POST["emailReset"];

    $sql = "SELECT * FROM  Korisnik  WHERE email='" . $email . "'";
    $logSql = "INSERT INTO dnevnikBaze(upit, Korisnik_idKorisnik) VALUES ('" .  $sql . "', " . $_SESSION['userID'] . ")";


    $checkmail = new Database();
    $checkmail->connectDB();

    $result = $checkmail->sqlQuery($sql);
    $checkmail->sqlQuery($logSql);
    $result2 = mysqli_num_rows($result);


    if ($result != null && $result2 == 1) {

        $newPass = rand(1000,50000);


        $to = mysqli_fetch_array($result)['email'];

        $subject = "Your Recovered Password";

        $message = 'Ovo je novi password:  '.$newPass;
        $headers = "From : cassiopeia@cas.com";
        if (mail($to, $subject, $message, $headers)) {
            echo "✔ Poruka je poslana na e-mail!";
            $sql = "UPDATE Korisnik SET lozinka='".$newPass."', potvrdaLozinke='".$newPass."' WHERE email='".$email."'";
            $logSql = "INSERT INTO dnevnikBaze(upit, Korisnik_idKorisnik) VALUES ('" .  $sql . "', " . $_SESSION['userID'] . ")";

            $result = $checkmail->sqlQuery($sql);
            $checkmail->sqlQuery($logSql);
            header("Location:https://barka.foi.hr/WebDiP/2017_projekti/WebDiP2017x138/prijava.php");
        } else {
            echo "Web<b>RIP</b>";
        }
    } else {
        echo "Email ne postoji! Potrebna je registracija!";
    }

    $checkmail->closeConnection();
}


require("templates/footer.php");

?>

