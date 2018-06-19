<?php
include ("templates/header.php");

?>
    <div class="main-body">
        <form method="POST" id="forma"  action="database/loginUser.php" enctype="multipart/form-data" >
            <!-- PRIJAVA -->
            <section id="login">
                <div class="form-input">
                    <label>Korisničko ime</label>
                    <input id="user-login" type="text" maxlength="20" name="usernameLog">
                </div>

                <div class="form-input">
                    <label>Lozinka</label>
                    <input id="pass-login" type="password" maxlength="20" name="passwordLog">
                </div>
                <button id="login-button"  type="submit" class="button">Prijava</button>

                <br>
                <br>

                <a href="zaboravljenaLozinka.php">Zaboravljena lozinka?</a>
            </section>
        </form>
    </div>


<?php


include ("templates/footer.php");


?>