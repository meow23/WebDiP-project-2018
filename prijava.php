<?php
include ("templates/header.php");
session_start();

?>
<form method="POST" id="forma" onsubmit="validate(event)"  enctype="multipart/form-data">
    <!-- PRIJAVA -->
    <section id="login">
        <div class="label-form">
            <label>Korisničko ime</label>
            <input id="user-login" type="text" maxlength="20" name="usernameLog">
        </div>

        <div class="label-form">
            <label>Lozinka</label>
            <input id="pass-login" type="text" maxlength="20" name="passwordLog">
        </div>
        <button id="login-button"  type="submit">Prijava</button>
    </section>
</form>

<?php


include ("templates/footer.php");


?>