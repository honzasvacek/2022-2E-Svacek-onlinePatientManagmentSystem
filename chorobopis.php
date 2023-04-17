<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chorobopis</title>
    <link rel="stylesheet" href="chorobopis.css">
</head>
<body>

<?php
    require("page.php");
    require("chorobopis_obsah.php");

    $domovska_stranka = new stranka();
    $obsah = new chorobopis_obsah();

    $domovska_stranka->obsah =$obsah->zobrazeni_obsahu("Vyhledejte pacienta");
    $domovska_stranka->zobrazeni_stranky();
?>

</body>
</html>