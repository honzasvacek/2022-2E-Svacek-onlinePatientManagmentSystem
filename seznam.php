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

    $domovska_stranka->obsah = $seznam_pacientu->zobrazeni_tabulky();

    $domovska_stranka->zobrazeni_stranky();
?>
