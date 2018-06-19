<?php
require ('templates/header.php');
include_once ('database/database.class.php');
?>
    <div class="">
        <?php

        $veza = new Database();
        $veza->connectDB();
        $korisnik = $_SESSION['userID'];
        $kategorija="";
        $sortiraj="";
        $odDo="";
        $sqlBaza = "SELECT o.naziv as OglasNaziv ,o.brojKlikova,vo.naziv as VrstaNaziv,o.datumPocetka,o.datumZavrsetka,vo.idVrstaOglasa  FROM Oglasi o left join VrstaOglasa vo on o.VrstaOglasa =vo.idVrstaOglasa WHERE Korisnik=$korisnik";

        $logWorkSql = "INSERT INTO dnevnikRada (vrijeme, radnja, Korisnik_idKorisnik) VALUES (NOW(), 'Pregled statistike', " . $_SESSION['userID'] . ")";
        $veza->sqlQuery($logWorkSql);


        //var_dump($sqlBaza);
        if(isset($_GET["brojK"])&&!empty($_GET["brojK"])){
            if($_GET["brojK"]=='asc'){
                $sortiraj=" ORDER BY o.brojKlikova DESC";
            }
            if($_GET["brojK"]=='desc'){
                $sortiraj=" ORDER BY o.brojKlikova ASC";
            }
        }
        if(isset($_GET["KATEGORIJA"])&&!empty($_GET["KATEGORIJA"])){
            $kategorija= " AND vo.idVrstaOglasa = ". $_GET["KATEGORIJA"]. " ";
        }
        if(isset($_GET["End"])&&!empty($_GET["End"])&&isset($_GET["Start"])&&!empty($_GET["Start"])){
            $odDo= " AND (o.datumPocetka BETWEEN '". $_GET["Start"]. " 00:00:00' AND '".$_GET["End"]. " 00:00:00') ";
            $odDo.= " AND (o.datumZavrsetka BETWEEN '". $_GET["Start"]. " 00:00:00' AND '".$_GET["End"]. " 00:00:00') ";
        }

        $sql= $sqlBaza .$kategorija .$odDo .$sortiraj . ";";
        //var_dump($sql);
        $logSql = "INSERT INTO dnevnikBaze(upit, Korisnik_idKorisnik) VALUES ('" .  $sql . "', " . $_SESSION['userID'] . ")";
        $rezultat = $veza->sqlQuery($sql);
        $veza->sqlQuery($logSql);
        //$oglas=mysqli_fetch_assoc($rezultat);
        if($rezultat!=null){
            echo "<form action=\"statistikaOglasa.php\" method=\"get\">";
            $vk = new Database();
            $vk->connectDB();
            $sddfsf="SELECT idVrstaOglasa,naziv from VrstaOglasa";
            $logSql = "INSERT INTO dnevnikBaze(upit, Korisnik_idKorisnik) VALUES ('" .  $sddfsf . "', " . $_SESSION['userID'] . ")";

            $rk = $vk->sqlQuery($sddfsf);
            $vk->sqlQuery($logSql);
            echo "<select id ='categoryAd' name='KATEGORIJA'>";

            var_dump($rk);
            while ($rvo = $rk->fetch_assoc()) {
                echo "<option value='".$rvo["idVrstaOglasa"]." '>".$rvo["naziv"]."</option>";
            }
            $vk->closeConnection();
            echo "</select>";

            echo "<input type=\"text\" name=\"Start\" placeholder=\"ODgggg-mm-dd\">
            <input type=\"text\" name=\"End\" placeholder=\"DOgggg-mm-dd\">
            <input type=\"submit\" value=\"FilterThis\" name=\"FilterThis\" >
            </form>";
            echo "<table class=\"table\">
					<thead>
						<th>Oglas</th>
						<th>";
            echo"<a href='";
            if(isset($_GET["brojK"])&&!empty($_GET["brojK"])){
                if($_GET["brojK"]=='asc'){
                    echo "statistikaOglasa.php?brojK=desc";
                }
                if($_GET["brojK"]=='desc'){
                    echo "statistikaOglasa.php?brojK=asc";
                }
            }else{
                echo "statistikaOglasa.php?brojK=asc";
            }

            echo"'>Broj klikova</a></th>
						<th>Vrsta oglasa</th>
						<th>Od</th><th>Do</th>
					</thead>
					<tbody>";

            while ($oglas = $rezultat->fetch_assoc()) {
                echo('<tr>');
                echo('<td>'.$oglas["OglasNaziv"].'</td>');
                echo('<td>'.$oglas["brojKlikova"].'</td>');
                echo('<td>'.$oglas["VrstaNaziv"].'</td>');
                echo('<td>'.$oglas["datumPocetka"].'</td>');
                echo('<td>'.$oglas["datumZavrsetka"].'</td>');
                //echo('<td><a href="proizvodpregled.php?id='.$oglas["idProizvod"].'">Pregled proizvoda</a></td>');
                echo('</tr>');
            }
            echo "	</tbody></table><br>";
        }
        $veza->closeConnection();


        ?>
    </div>


<?php
require ('templates/footer.php');?>