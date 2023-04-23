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
    require($_SERVER['DOCUMENT_ROOT'].'/Page/page.php');
    require($_SERVER['DOCUMENT_ROOT'].'/Page/functions.php');
    require("chorobopis_obsah.php");

    class chorobopis extends chorobopis_obsah
    {
        public function ziskani_dat()
        {
            chorobopis_send();
        }
    }

    $domovska_stranka = new stranka();
    $obsah = new chorobopis();

    $domovska_stranka->obsah =$obsah->zobrazeni_obsahu("Vyhledejte pacienta", "", 0);
    $domovska_stranka->zobrazeni_stranky(true);
?>

</body>

</html>