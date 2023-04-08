<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Účet - odebrání</title>
    <link rel="stylesheet" href="ucet.css">
</head>
<body>

<?php
    //potřebné soubory
    require("page.php");
    require("ucet_obsah.php");

    class ucet_delete_patient extends ucet_obsah
    {
        
    }

    //vypsání obsahu
    $domovska_stranka = new stranka();
    $ucet_obsah = new ucet_delete_patient();

    $domovska_stranka->obsah =$ucet_obsah->ucet_obsah("Smazání pacienta", "ucet_delete_patient_save.php");

    $domovska_stranka->zobrazeni_stranky();
?>
</body>
