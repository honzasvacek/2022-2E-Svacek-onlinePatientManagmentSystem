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

//vypsání obsahu
$domovska_stranka = new stranka();
$ucet_obsah = new ucet_edit_patient_save();

$domovska_stranka->obsah =$ucet_obsah->ucet_obsah("Pacient", "ucet_edit_patient_save.php");

$domovska_stranka->zobrazeni_stranky();
?>
   <script>
       //nastavím spanu, což je křížek, akci onclick
       document.querySelector('.popup-image span').onclick = () =>
       {
           //když se spustí onclick schovám popup
           document.querySelector('.popup-image').style.display = 'none';
       }
   </script>

</body>