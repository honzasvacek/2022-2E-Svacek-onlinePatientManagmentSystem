<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seznam</title>
    <link rel="stylesheet" href="seznam.css">
</head>
<body>
    
</body>
</html>
<?php
require("page.php");
require("seznamtable.php");

$domovska_stranka = new stranka();
$seznam_pacientu = new seznam_tabulka; 

$jeHledano = true;

$domovska_stranka->zobrazeni_stranky();
$domovska_stranka->obsah = $seznam_pacientu->zobrazeni_obsahu($jeHledano);
?>

<script>
        //nastavím spanu, což je křížek, akci onclick
        document.querySelector('.popup-image span').onclick = () =>
        {
            //když se spustí onclick schovám popup
            document.querySelector('.popup-image').style.display = 'none';
        }
</script>
