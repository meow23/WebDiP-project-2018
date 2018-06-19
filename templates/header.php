<?php

    if($_SERVER["HTTPS"] != "on")
    {
        header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        exit();
    }
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Cassiopeia - shopping out of this world!</title>


    <link rel="stylesheet" type="text/css" href="css/miasimuni.css">
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext" rel="stylesheet">
    <script language="JavaScript" type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script src="JavaScript/miasimuni.js" type="text/javascript"></script>
    <script src="JavaScript/jquery.js" type="text/javascript"></script>
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