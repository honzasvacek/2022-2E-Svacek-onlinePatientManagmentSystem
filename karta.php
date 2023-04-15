<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karta</title>
    <link rel="stylesheet" href="karta.css">
</head>
<body>

<?php
    //potřebné soubory
    require("page.php");
    require("karta_class.php");

    //generování stránky
    $domovska_stranka = new stranka();
    $obsah = new karta();

    $values = array("", "", "", "", "", "", "", "", "", "", "", "",
                    "", "", "", "", "", "", ""
                    );

    $contacts = array("Telefonní číslo", "E-mail");
    $domovska_stranka->obsah = $obsah->zobrazeni_karty($values, "vyhledejte požadovaného pacienta", $contacts);

    $domovska_stranka->zobrazeni_stranky();
?>

</body>