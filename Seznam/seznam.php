<?php
    require($_SERVER['DOCUMENT_ROOT'].'/Page/page.php');
    require($_SERVER['DOCUMENT_ROOT'].'/Page/functions.php');
    require("seznamtable.php");

    class seznam_stranka extends stranka
    {
        public $titulek = "Seznam";

        public function volitelne_styly()
        {
            echo "<link rel=\"stylesheet\" href=\"seznam.css\">";
        }
    }
   
    $stranka = new seznam_stranka();
    $seznam_pacientu = new seznam_tabulka();

    $stranka->zobrazeni_stranky(true);

    $jeHledano = false;
    $stranka->obsah = $seznam_pacientu->zobrazeni_obsahu($jeHledano);
?>
   



