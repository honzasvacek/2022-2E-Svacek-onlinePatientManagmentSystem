<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Účet - přidání</title>
    <link rel="stylesheet" href="ucet.css">
    <link rel="stylesheet" href="../Page/popup.css">
</head>
<body>

<?php
    //potřebné soubory
    require_once($_SERVER['DOCUMENT_ROOT'].'/Page/page.php');
    require("ucet_obsah.php");

    class ucet_add_patient extends ucet_obsah
    {
        public function zobrazeni_tlacitek()
        {
            
        }

        public function submit_tlacitko()
        {
           echo "<div style=\"border-top: 0.5px solid gray;\" class=\"buttons-div\">";
           echo "<input class=\"submit-button\" type=\"submit\" value=\"Přidat\">";
           echo "</div>";
        }
    }

    //vypsání obsahu
    $domovska_stranka = new stranka();
    $ucet_obsah = new ucet_add_patient();

    $domovska_stranka->obsah =$ucet_obsah->ucet_obsah("Přidání pacienta", "ucet_add_patient_save.php");
    $domovska_stranka->zobrazeni_stranky(false);
?>
</body>
