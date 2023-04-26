<?php
    //potřebné soubory
    require($_SERVER['DOCUMENT_ROOT'].'/Page/page.php');
    require("karta_class.php");

    class karta_stranka extends stranka
    {
        public $titel = "Karta";
        
        public function volitelne_styly()
        {
            echo "<link rel=\"stylesheet\" href=\"../Karta/karta.css\">";
        }
    }

    //generování stránky
    $stranka = new karta_stranka();
    $obsah = new karta();

    $values = array("", "", "", "", "", "", "", "", "", "", "", "",
                    "", "", "", "", "", "", ""
                    );

    $contacts = array("Telefonní číslo", "E-mail");
    $stranka->obsah = $obsah->zobrazeni_karty($values, "vyhledejte požadovaného pacienta", $contacts);

    $stranka->zobrazeni_stranky(true);
?>
