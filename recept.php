<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ůčet - výsledek</title>
    <link rel="stylesheet" href="recept.css">
</head>
<body>
<?php
    class recept
    {
        public function zobrazeni_obsahu_receptu()
        {
            ?>
            <div class="container">
                <div class="row-1">

                </div>
                <div class="row-2">

                </div>
            </div>
            <?php
        }
    }

    require("page.php");

    $domovska_stranka = new stranka();
    $obsah = new recept;

    $domovska_stranka->obsah = $obsah->zobrazeni_obsahu_receptu();
    $domovska_stranka->zobrazeni_stranky();
?>
</body>
