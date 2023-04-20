<?php
    //Třída stránky umožňující dynamické generování kodu v dalších php souborech
    class stranka
    {
        //vlastnosti, které budeme chtít na dalších stránkách měnit
        public $obsah;
        public $titulek = "Svacek Health";
        public $tlacitka = array("Seznam" => "../Seznam/seznam.php", //klíč - jméno tlačítka, //hodnota - url adresa, na kterou odkazují
                                 "Účet" => "../Účet/ucet.php", 
                                 "Karta" => "../Karta/karta.php", 
                                 "Chorobopis" => "../Chorobopis/chorobopis.php", 
                                 "Recept" => "../Recepty/recept.php"
                                );
        public $vyhledavaci_pole = array("/Seznam/seznam.php" => "resultseznam.php", //klíč - současná url adresa, //hodnota - url adresa, na kterou budou odkazovat
                                        "/Účet/ucet.php" => "ucet.php",
                                        "/Karta/karta.php" => "resultkarta.php",
                                        "/Chorobopis/chorobopis.php" => "resultchorobopis.php",
                                        "/Recepty/recept.php" => "resultrecept.php",
                                        "/Seznam/resultseznam.php" => "resultseznam.php",
                                        "/Účet/resultucet.php" => "resultucet.php",
                                        "/Karta/resultkarta.php" => "resultkarta.php",
                                        "/Chorobopis/resultchorobopis.php" => "resultchorobopis.php",
                                        "/Účet/resultrecept.php" => "resultrecept.php",
                                        "/index.php" => "index.php",
                                        "/Účet/ucet_add_patient.php" => "ucet_add_patient.php",
                                        "/Účet/ucet_edit_patient.php" => "ucet_edit_patient.php",
                                        "/Účet/ucet_delete_patient.php" => "ucet_delete_patient.php",
                                        "/Účet/ucet_add_patient_save.php" => "ucet_add_patient.php",
                                        "/Účet/ucet_edit_patient_save.php" => "ucet_edit_patient.php",
                                        "/Účet/ucet_delete_patient_save.php" => "ucet_delete_patient.php",
                                        "/Chorobopis/chorobopis_addrecord.php" => "chorobopis_addrecord.php"
                                    );

        function __set($name, $value)
        {
            //doplnit kontrolu hodnot
            $this->name = $value;
        }

        public function zobrazeni_stranky()
        {
            echo "<!DOCTYPE html>\n<html lang=\"en\">\n<head>\n"; //začátek stránky v html
            $this->zobrazení_titulku();
            echo "<meta charset=\"UTF-8\">";
            $this->zobrazení_stylu();
            echo "</head>\n<body class=\"body\">\n";
            $this->zobrazeni_zahlavi();
            echo $this->obsah;
            $this->zobrazeni_navpanelu($this->tlacitka);
            echo "</body>\n</html>\n";
        }

        public function zobrazení_titulku()
        {
            echo "<title>".$this->titulek."</title>";
        }

        public function zobrazení_stylu()
        {
            ?>
            <link href="../Page/sidebar.css"  rel="stylesheet">
            <link href="../Page/header.css"  rel="stylesheet">
            <?php
        }

        public function zobrazeni_zahlavi()
        {
            ?>
            <form method="post" action="<?=$this->nastaveni_akce($this->vyhledavaci_pole)?>">
            <div class="header">
                <div class="left_section">
                    <a href="../IndexPage/index.php">
                        <img class="logo_picture" src="../Pictures/Header-buttons/SHPictureLogo.PNG">
                    </a>
                    <img class="logo_svacek" src="../Pictures/Header-buttons/SvacekLogo.PNG">
                </div>
                <div class="middle_section">
                    <?php $this->zobrazeni_searchbaru() ?>
                </div>
                <div class="right_section">
                    <img class="logo_health" src="../Pictures/Header-buttons/HealthLogo.PNG" alt="">
                </div>
            </div>
            </form>
            <?php
        }

        function zobrazeni_searchbaru()
        {
            ?>
            <input class="search_bar" type="text" placeholder="Zadejte rodné číslo" name="rodne_cislo">
            <?php
        }

        public function nastaveni_akce($arr)
        {
            $aktualni_url = $_SERVER['PHP_SELF'];
            return $arr[$aktualni_url];
        }

        public function zobrazeni_navpanelu($tlacitka)
        {
            echo "<div class=\"sidebar\">"; //začátek navpanelu

            foreach($tlacitka as $jmeno => $url)
            {
                $this->zobrazeni_tlacitek($jmeno, $url, !$this->jeURLSoucasnaStranka($url));
            }

            echo "</div>"; //konec navpanelu
        }

        public function jeURLSoucasnaStranka($url)
        {
            if(strpos($_SERVER['PHP_SELF'], $url) === false)
            {
                //soucasna url adresa stranky se neshoduje s url odkazem stranky tlacitka
                return false;
            } else
              {
                //soucasna url adresa stranky se shoduje s url odkazem stranky tlacitka
                return true;
              }
        }

        public function zobrazeni_tlacitek($jmeno, $url, $aktivni = true)
        {
            if($aktivni)
            {
                //soucasna url adresa stranky se neshoduje s url odkazem stranky tlacitka => klasicky design
                ?>
                <div class="menuitem" data-tooltip="<?=$jmeno?>">
                    <a href="<?=$url?>">
                        <img class="<?=mb_strtolower($jmeno)?>" src="../Pictures/Sidebar-buttons/<?=mb_strtolower($jmeno)?>.png">
                    </a>
                </div>
                <?php
            } else
              {
                   //soucasna url adresa stranky se shoduje s url odkazem stranky tlacitka => tlačítko bude mít šedivou barvu
                   ?>
                    <div style="background-color:lightslategray;" class="menuitem" data-tooltip="<?=$jmeno?>">
                        <a href="<?=$url?>">
                            <img class="<?=mb_strtolower($jmeno)?>" src="../Pictures/Sidebar-button/<?=mb_strtolower($jmeno)?>.png">
                        </a>
                    </div>
                   <?php
              }
        }

    }
?>
