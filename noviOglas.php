<?php
    include ('templates/header.php')
?>
<br>
<form id="newAdd" method="post" >
    <div>
        <label>Naziv oglasa: </label>
        <input type="text" id="nameAd" name="nameAd">
    </div>
    <br>
    <div>
        <label>Datum početka: </label>
        <input type="date" id="startAd" name="startAd">
    </div>
    <br>
    <div>
        <label>Datum završetka: </label>
        <input type="date" id="endAd" name="endAd">
    </div>
    <br>


    <div>
        <label>Vrsta oglasa:</label>
        <select id ='categoryAd' name='category[]'>
        <?php
        include ("database/categoryAd.php");
        ?>
        </select>

    </div>








</form>
<?php
require ("templates/footer.php");
?>