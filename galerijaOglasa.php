<?php
require ('templates/header.php');
include_once ('database/database.class.php');
?>
    <div class="">
        <?php

        $veza = new Database();
        $veza->connectDB();
        $korisnik = $_SESSION['userID'];
        $sql = "SELECT * FROM Oglasi WHERE Korisnik=$korisnik";
        $logSql = "INSERT INTO dnevnikBaze(upit, Korisnik_idKorisnik) VALUES ('" .  $sql . "', " . $_SESSION['userID'] . ")";



        $rezultat = $veza->sqlQuery($sql);
        $veza->sqlQuery($logSql);
        //$oglas=mysqli_fetch_assoc($rezultat);

        while ($oglas = $rezultat->fetch_assoc()) {


            echo "
                    <figure class='galerija'>
                    <img src=\"images/{$oglas['slika']}\" alt=\"{$oglas['naziv']}\">
                    <figcaption>{$oglas['naziv']}</figcaption>
                    </figure>
                    <p>Broj klikova: {$oglas['brojKlikova']}</p>
                    <p>Status oglasa: {$oglas['prihvacen']}</p>                    
                    <a href=\"azuriranjeOglasa.php?id=".$oglas['idOglas']."\">Azuriranje oglasa</a> ";
        }


        $veza->closeConnection();


        ?>
    </div>


<?php
require ('templates/footer.php');?>