<?php
    //Třída stránky umožňující dynamické generování kodu v dalších php souborech
    class stranka
    {
        //vlastnosti, které budeme chtít na dalších stránkách měnit
        public $obsah;
        public $titulek;
        public $tlacitka = array("Seznam" => "../Seznam/seznam.php", //klíč - jméno tlačítka, //hodnota - url adresa, na kterou odkazují
                                 "Účet" => "../Účet/ucet.php", 
                                 "Karta" => "../Karta/karta.php", 
                                 "Chorobopis" => "../Chorobopis/chorobopis.php", 
                                 "Recept" => "../Recepty/recept.php"
                                );
        public $vyhledavaci_pole = array("/Seznam/seznam.php" => "resultseznam.php", //klíč - současná url adresa, //hodnota - url adresa, na kterou budou odkazovat
                                        "/Karta/karta.php" => "resultkarta.php",
                                        "/Chorobopis/chorobopis.php" => "resultchorobopis.php",
                                        "/Seznam/resultseznam.php" => "resultseznam.php",
                                        "/Účet/resultucet.php" => "resultucet.php",
                                        "/Karta/resultkarta.php" => "resultkarta.php",
                                        "/Chorobopis/resultchorobopis.php" => "resultchorobopis.php",
                                        "/Účet/resultrecept.php" => "resultrecept.php",
                                        "/Účet/ucet_edit_patient.php" => "ucet_edit_patient.php",
                                        "/Účet/ucet_delete_patient.php" => "ucet_delete_patient.php",
                                        "/Chorobopis/chorobopis_addrecord.php" => "resultchorobopis.php"
                                    );

        function __set($name, $value)
        {
            $this->name = $value;
        }

        public function zobrazeni_stranky($searchbar)
        {
            echo "<!DOCTYPE html>\n<html lang=\"en\">\n<head>\n";
            echo "<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">";
            echo "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">"; //začátek stránky v html
            $this->zobrazení_titulku();
            echo "<meta charset=\"UTF-8\">";
            $this->zobrazení_stylu();
            $this->volitelne_styly();
            echo "</head>\n<body class=\"body\">\n";
            $this->zobrazeni_zahlavi($searchbar);
            echo $this->obsah;
            $this->zobrazeni_navpanelu($this->tlacitka);
            $this->zobrazeni_zpravy();
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
            <script src="../Page/popup.js"></script>
            <?php
        }

        public function volitelne_styly()
        {
            //v defaultu nechám prázndou
        }

        public function zobrazeni_zahlavi($searchbar)
        {
            ?>
            <form method="post" action="<?=$this->nastaveni_akce($this->vyhledavaci_pole, $searchbar)?>">
            <div class="header">
                <div class="left_section">
                    <a href="../IndexPage/index.php">
                        <img class="logo_picture" src="../Pictures/Header-buttons/SHSymbolLogo.PNG">
                    </a>
                    <img class="logo_svacek" src="../Pictures/Header-buttons/SHSvacek.PNG">
                </div>
                <div class="middle_section">
                    <?php 
                    if($searchbar == true)
                    {
                        $this->zobrazeni_searchbaru(); 
                    }
                    ?>
                </div>
                <div class="right_section">
                    <img class="logo_health" src="../Pictures/Header-buttons/SHHealth.PNG" alt="">
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

        public function nastaveni_akce($arr, $searchbar)
        {
            if($searchbar == true)
            {
                $aktualni_url = $_SERVER['PHP_SELF'];
                return $arr[$aktualni_url];
            } else {
                return "";
            }
        }

        public function zobrazeni_navpanelu($tlacitka)
        {
            echo "<div class=\"sidebar\">"; //začátek navpanelu

            foreach($tlacitka as $jmeno => $url)
            {
                $this->zobrazeni_tlacitek($jmeno, $url, $this->jeURLSoucasnaStranka($url));
            }

            echo "</div>"; //konec navpanelu
        }

        public function jeURLSoucasnaStranka($url)
        {
            $url_formated = substr($url, 2);
            if(strpos($_SERVER['PHP_SELF'], $url_formated) === false)
            {
                //soucasna url adresa stranky se neshoduje s url odkazem stranky tlacitka
                return false;
            } else
              {
                //soucasna url adresa stranky se shoduje s url odkazem stranky tlacitka
                return true;
              }
        }

        public function zobrazeni_tlacitek($jmeno, $url, $aktivni)
        {
            if($aktivni == false)
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
                            <img class="<?=mb_strtolower($jmeno)?>" src="../Pictures/Sidebar-buttons/<?=mb_strtolower($jmeno)?>.png">
                        </a>
                    </div>
                   <?php
              }
        }

        public function obsah_zpravy()
        {
            //v defaultu nic
        }

        public function zobrazeni_zpravy()
        {
            $this->obsah_zpravy();
            ?>
            <script src="../Page/popup.js"></script>
            <?php
        }

    }
?>
