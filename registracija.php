<?php
    include ("templates/header.php");
    ?>
<div class="main-body">
    <form method="POST" id="forma"  onsubmit="validate(event)" action="database/insertNewUser.php" enctype="multipart/form-data">
        <!-- REGISTRACIJA -->
        <section id="registration">
            <div class="form-input">
                <label>Ime</label>
                <input id="name" type="text" maxlength="25" name="name-reg">
            </div>
            <div class="form-input">
                <label>Prezime</label>
                <input id="surname" type="text" maxlength="40" name="surname-reg">
            </div>
            <div class="form-input">
                <label>Korisničko ime</label>
                <input id="username" type="text" maxlength="25" name="username-reg">


                <label id="user-availability"></label>
            </div>
            <div class="form-input">
                <label>Lozinka</label>
                <input id="pass" type="password" maxlength="30" name="password-reg">
            </div>
            <div class="form-input">
                <label>Ponovi lozinku</label>
                <input id="pass-valid" type="password" maxlength="30" name="password-valid">
            </div>
            <div class="form-input">
                <label>e-mail</label>
                <input id="email" type="email" maxlength="30" name="email-reg">
            </div>


            <input type="text" id="captcha" disabled/><br/><br/>
            <input type="text" id="inputText"/><br/><br/>
            <button id="generateCap" type="button" class="button">Osvježi provjeru</button>
            <br>
            <br>
            <button id="registration-button"  name = "btnRegistration" value="Registracija" type="submit" class="button">Registracija</button>

        </section>
    </form>
    <br><br><br>
</div>


<?php
    include ("templates/footer.php");
?>