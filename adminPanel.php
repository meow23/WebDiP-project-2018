<?php

if ($_SERVER["HTTPS"] != "on") {
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}
session_start();

if(!isset($_SESSION['userRole']) || (isset($_SESSION['userRole'])&&$_SESSION['userRole']!=1)){
    header("location: prijava.php");
    exit();
}
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title> Cassiopeia - shopping out of this world!</title>


        <link rel="stylesheet" type="text/css" href="css/miasimuni.css">
        <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext"
              rel="stylesheet">
        <script language="JavaScript" type="text/javascript"
                src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <!--        <script src="JavaScript/miasimuni.js" type="text/javascript"></script>-->
        <!--        <script src="JavaScript/jquery.js" type="text/javascript"></script>-->

        <script src="JavaScript/ajaxDb.js" type="text/javascript"></script>

    </head>

    <header class="title-row">
        <div id="login-button" class="side-header-link">
            <a href="prijava.php"> Prijava </a>
            <a href="registracija.php"> Registracija </a>
            <?php
            if(isset($_SESSION['userID'])){
                echo "<a href='database/logoutUser.php'>Odjava</a>";
            }
            ?>
        </div>
        <div class="casssiopeia-logo"></div>

        <br><br>

    </header>
    <nav class="navigation-bar">
        <a href="proizvodi.php">Proizvodi</a>

        <?php

        if (isset($_SESSION['userRole']) && $_SESSION['userRole'] <= 2) {
            echo'<a href="popisnarudzbi.php">Popis narudžbi</a>';
        }

        if (isset($_SESSION['userRole']) && $_SESSION['userRole'] <= 2) {
            echo'<a href="dodajproizvod.php">Dodaj proizvod</a>';
        }

        if(isset($_SESSION['userRole'])){
            echo "<a href=\"noviOglas.php\">Naruči oglas</a>
              <a href=\"galerijaOglasa.php\">Glaerija oglasa</a>";
        }

        if(isset($_SESSION['userRole'])&&$_SESSION['userRole']==1){
            echo "<a href=\"adminPanel.php\">Administrator</a>
              ";
        }


        ?>
    </nav>


    <div class="main-body">

        <h1>Administratorski panel</h1>

        <h2>Konfiguracija</h2>

        <table class="table">
            <thead>
            <tr>
                <th>Id mogućnosti</th>
                <th>Naziv</th>
                <th>Vrijednost</th>
                <th>Opcije</th>
            </tr>
            </thead>
            <tbody id="sveKonfiguracije">

            </tbody>
        </table>

        <h2>Kategorije predmeta</h2>

        <div id="kategorijeTablica">
            <button class="button button-send" onclick="dodajKategoriju()">Dodaj kategoriju</button>
            <table class="table">
                <thead>
                <th>Id kategorije</th>
                <th>Naziv</th>
                <th>Moderatori</th>
                </thead>
                <tbody id="sveKategorije">

                </tbody>
            </table>
        </div>

        <div id="kategorijeUredi">
            <h3>Uredi moderatore za kategoriju</h3>

            <a onclick="ucitajKategorije()">< Natrag</a>

            <h4>Svi moderatori</h4>
            <table class="table">
                <thead>
                <th>Id moderatora</th>
                <th>Korisničko ime</th>
                </thead>
                <tbody id="sviModeratoriKategorije">

                </tbody>
            </table>

            <h4>Dodaj moderatora</h4>
            <div style="display: flex">
                <select id="noviModeratorSelect"></select>
                <button class="button button-send" id="dodajNovogModeratora">Dodaj</button>
            </div>
        </div>

        <h2>Blokirani korisnici</h2>

        <table class="table">
            <thead>
            <tr>
                <th>Id korisnika</th>
                <th>Korisničko ime</th>
                <th>Blokiran</th>
                <th> </th>
            </tr>
            </thead>
            <tbody id="sviKorisniciBlok">

            </tbody>
        </table>
        <div id="strSviKorisnici"></div>

        <h2>Dnevnik prijava</h2>

        <table class="table">
            <thead>
            <tr>
                <th>Id zapisa</th>
                <th>Uspjela prijava</th>
                <th>Vrijeme prijave</th>
                <th>Korisnik</th>
            </tr>
            </thead>
            <tbody id="dnevnikPrijava">

            </tbody>
        </table>
        <div id="strDnevnikPrijava"></div>

        <h2>Dnevnik rada</h2>

        <table class="table">
            <thead>
            <tr>
                <th>Id zapisa</th>
                <th>Radnja</th>
                <th>Vrijeme prijave</th>
                <th>Korisnik</th>
            </tr>
            </thead>
            <tbody id="dnevnikRada">

            </tbody>
        </table>
        <div id="strDnevnikRada"></div>

        <h2>Dnevnik baze</h2>

        <table class="table">
            <thead>
            <tr>
                <th>Id zapisa</th>
                <th>Upit</th>
                <th>Korisnik</th>
            </tr>
            </thead>
            <tbody id="dnevnikBaze">

            </tbody>
        </table>
        <div id="strDnevnikBaze"></div>

    </div>

<?php

include("templates/footer.php")

?>