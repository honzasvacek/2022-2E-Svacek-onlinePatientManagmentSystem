<?php   
    require($_SERVER['DOCUMENT_ROOT'].'/Page/page.php');
    require($_SERVER['DOCUMENT_ROOT'].'/Page/functions.php');
    require("seznamtable.php");

    class seznam_stranka extends stranka
    {
        public $titel = "Seznam";

        public function volitelne_styly()
        {
            echo "<link rel=\"stylesheet\" href=\"seznam.css\">";
            echo "<link rel=\"stylesheet\" href=\"../Page/popup.css\">";
        }

        public function obsah_zpravy()
        {
            if(patientExist(trim($_POST['rodne_cislo'])))
            {
                err_msg("Hledání - Úspěšné", "Pacient existuje");
            } else {
                err_msg("Hledání - Neúspěšné", "Pacient neexistuje");
            }
        }
    }

    $stranka = new seznam_stranka();
    $seznam_pacientu = new seznam_tabulka(); 

    $jeHledano = true;

    $stranka->zobrazeni_stranky(true);
    $stranka->obsah = $seznam_pacientu->zobrazeni_obsahu($jeHledano);
?>



