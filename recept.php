<?php
    require("page.php");

    $domovska_stranka = new stranka();

    $domovska_stranka->obsah ="
    <h1>Recept</h1>";

    $domovska_stranka->zobrazeni_stranky();
?>
