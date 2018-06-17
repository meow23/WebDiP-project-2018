<?php
    include ("templates/header.php");
    ?>
<form method="POST" id="forma"  onsubmit="validate(event)" action="database/insertNewUser.php" enctype="multipart/form-data">
<!-- REGISTRACIJA -->
    <section id="registration">
        <div class="label-form">
            <label>Ime</label>
            <input id="name" type="text" maxlength="25" name="name-reg">
        </div>
        <div class="label-form">
            <label>Prezime</label>
            <input id="surname" type="text" maxlength="40" name="surname-reg">
        </div>
        <div class="label-form">
            <label>Korisničko ime</label>
            <input id="username" type="text" maxlength="25" name="username-reg">


            <label id="user-availability"></label>
        </div>
        <div class="label-form">
            <label>Lozinka</label>
            <input id="pass" type="password" maxlength="30" name="password-reg">
        </div>
        <div class="label-form">
            <label>Ponovi lozinku</label>
            <input id="pass-valid" type="password" maxlength="30" name="password-valid">
        </div>
        <div class="label-form">
            <label>e-mail</label>
            <input id="email" type="email" maxlength="30" name="email-reg">
        </div>


        <input type="text" id="captcha" disabled/><br/><br/>
        <input type="text" id="inputText"/><br/><br/>
        <button id="generateCap" type="button">Osvježi provjeru</button>
        <br>
        <br>
        <button id="registration-button"  name = "btnRegistration" value="Registracija" type="submit" >Registracija</button>

    </section>
</form>
<br><br><br>

<?php
    include ("templates/footer.php");
?>