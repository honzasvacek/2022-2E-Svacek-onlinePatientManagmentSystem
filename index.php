<?php
    require("page.php");

    $domovska_stranka = new stranka();

    $domovska_stranka->obsah ="
    <h1>Vítejte na domovké stránce vítáme vás</h1>";

    $domovska_stranka->zobrazeni_stranky();
?>
