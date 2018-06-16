<?php
    include ('templates/header.php')
?>
<header>
    <button id="logOff">Odjava</button>
</header>
<form id="newAdd" method="post" >
    <div>
        <label>Naziv oglasa: </label>
        <input type="text" id="nameAd" name="nameAd">
    </div>

    <div>
        <label>Datum početka: </label>
        <input type="date" id="startAd" name="startAd">
    </div>

    <div>
        <label>Datum završetka: </label>
        <input type="date" id="endAd" name="endAd">
    </div>





</form>
