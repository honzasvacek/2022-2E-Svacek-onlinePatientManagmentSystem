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
    
<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/Page/page.php');
    require("../Page/functions.php");
    require("seznamtable.php");

    $domovska_stranka = new stranka();
    $seznam_pacientu = new seznam_tabulka();

    $jeHledano = false;
    $domovska_stranka->obsah = $seznam_pacientu->zobrazeni_obsahu($jeHledano);

    $domovska_stranka->zobrazeni_stranky(true);

?>
    </body>
</html>
