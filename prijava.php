<?php
include ("templates/header.php");


?>
<form method="POST" id="forma" action="database/insertNewUser.php" onsubmit="validate(event)"  enctype="multipart/form-data">
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