<?php
require("templates/header.php");
include("database/database.class.php");
?>
<form id="lostPass" method="post">

    <label> Unesite e-mail adresu:</label>
    <input id="email" type="email" maxlength="30" name="emailReset">
    <br>
    <button id="sendEmail" name="btnSend" value="sendEmail" type="submit">Pošalji</button>
</form>
<?php
if (isset($_POST['emailReset'])) {

    $email = $_POST["emailReset"];

    $sql = "SELECT * FROM  Korisnik  WHERE email='" . $email . "'";

    $checkmail = new Database();
    $checkmail->connectDB();

    $result = $checkmail->sqlQuery($sql);
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
            $result = $checkmail->sqlQuery($sql);
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

