<?php
    require($_SERVER['DOCUMENT_ROOT'].'/Page/page.php');
    require('admin_obsah.php');

    class admin_stranka extends stranka
    {
        public $titel = "Admin";

        public function volitelne_styly()
        {
            echo "<link rel=\"stylesheet\" href=\"admin.css\">";
        }
    }

    $stranka = new  admin_stranka();
    $obsah = new admin();

    $stranka->obsah = $obsah->obsah();

    $stranka->zobrazeni_stranky(false);
?>
   