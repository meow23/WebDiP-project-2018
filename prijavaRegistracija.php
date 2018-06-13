<?php
    include ("templates/header.php");

    if($_SERVER["HTTPS"] != "on")
    {
        header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        exit();
    }

    ?>
<form method="POST" action="database/insertNewUser.php">
<!-- PRIJAVA -->
    <section id="login">
        <div class="label-form">
            <label>Korisničko ime</label>
            <input type="text" maxlength="20" name="username">
        </div>

        <div class="label-form">
            <label>Lozinka</label>
            <input type="text" maxlength="20" name="password">
        </div>
        <button id="login-button"  type="submit">Prijava</button>
    </section>

<!-- REGISTRACIJA -->
    <section id="registration">
        <div class="label-form">
            <label>Ime</label>
            <input type="text" maxlength="20" name="name-reg">
        </div>
        <div class="label-form">
            <label>Prezime</label>
            <input type="text" maxlength="20" name="surname-reg">
        </div>
        <div class="label-form">
            <label>Korisničko ime</label>
            <input type="text" maxlength="20" name="username-reg">
        </div>
        <div class="label-form">
            <label>Lozinka</label>
            <input type="text" maxlength="20" name="password-reg">
        </div>
        <div class="label-form">
            <label>Ponovi lozinku</label>
            <input type="text" maxlength="20" name="password-valid">
        </div>
        <div class="label-form">
            <label>e-mail</label>
            <input type="email" maxlength="20" name="email-reg">
        </div>
        <button id="registration-button" name = "btnRegistration" value="regSubmit" type="sumbit" action="../database/insertNewUser.php">Registracija</button>
    </section>
</form>

<?php
    include ("templates/footer.php");
?>
