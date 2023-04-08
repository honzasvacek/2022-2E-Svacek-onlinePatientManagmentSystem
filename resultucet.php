<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ůčet - výsledek</title>
    <link rel="stylesheet" href="ucet.css">
</head>
<body>
<?php
    require("page.php");
    require("ucet_obsah.php");

    $domovska_stranka = new stranka();
    $ucet_obsah = new ucet_obsah();

    $domovska_stranka->obsah =$ucet_obsah->ucet_obsah("Pacient", "resultucet.php");
    $domovska_stranka->zobrazeni_stranky();

    echo "<div class=\"overlay\">";
    echo "</div>";
    echo "<div class=\"popup\">";
    echo "<div><h2>Nevybrali jste žádnou akci</h2></div>";
    echo "<div><p>Prvně musíte zvolit akci - přidání, upravení, smazání pacienta pomocí kliknutí na jedno z tlačítek</p></div>";
    echo "<div style=\"margin-top: 30px;\">";
    echo "<form action=\"ucet.php\">";
    echo "<button class=\"btn-zpatky\" type=\"submit\">Zpátky</button>";
    echo "</form>";
    echo "</div>";
    echo "</div>";
?>
</body>