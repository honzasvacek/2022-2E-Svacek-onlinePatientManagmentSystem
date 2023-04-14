<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Účet</title>
    <link rel="stylesheet" href="ucet.css">
</head>
<body>
<?php
    require("page.php");
    require("ucet_obsah.php");

    class stranka_ucet extends stranka
    {
        public function zobrazeni_searchbaru()
        {
            //nevypním nic ,takže se nezobrazí a to chci
        }
    }

    $domovska_stranka = new stranka_ucet();
    $ucet_obsah = new ucet_obsah();

    $domovska_stranka->obsah =$ucet_obsah->ucet_obsah("Pacient", "ucet.php");

    $domovska_stranka->zobrazeni_stranky();
?>
</body>
