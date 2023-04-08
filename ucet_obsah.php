<?php
    class ucet_obsah
    {
        public $data = array("surname" => "Jméno", "lastname" => "Příjmení", "identification_number" => "Rodné číslo",
                             "telefon_number"  => "Telefonní číslo", "email"  => "E-mail", "country"  => "Země" ,
                             "city"  => "Město", "zip_code"  => "Poštovní směrovací číslo", "street"  => "Ulice", "house_number"  => "Číslo popisné",
                             "weight" => "Váha", "height" => "Výška", "blood_type"  => "Krevní skupina", 
                             "chronic_diseases"  => "Chronické nemoci", "allergic_diseases"  => "Alergie",
                             "genetic_diseases"  => "Genetické nemoci", "hereditary_diseases"  => "Dědičné nemoci"
                            );
        

        public function ucet_obsah($title, $action){
            echo "<div class=\"container\">";
            $this->zobrazeni_obsahu_uctu($title, $this->data, $action);
            $this->submit_tlacitko();
            echo "</form>";
            $this->zobrazeni_tlacitek();
            echo "</div>";
            $this->poslani_dat($this->data);
        }

        public function poslani_dat($arr)
        {
                
        }
        
        public function zobrazeni_obsahu_uctu($title, $arr, $action)
        {
            $i = 0;
            echo "<form action=\"$action\" method=\"POST\">";
            echo "<div class=\"account_form\">";
            echo "<div class=\"header_div\"><h1 class=\"headline\">$title<h1></div>";
            echo "<div class=\"section-3-div\">";
            foreach($arr as $dbname => $czname)
            {
                if($i == 0)
                {
                    //chci pritnout první div
                    echo "<div class=\"left-div\">";
                    echo "<h2>Základní údaje</h2>";
                }
                if($i==3)
                {
                    //chci pritnout druhý div a ukončit první
                    echo "</div>";
                    echo "<div class=\"middle-div\">";
                    echo "<h2>Kontakt</h2>";
                }
                if($i==10)
                {
                    //chci pritnout třetí div a ukončit druhý
                    echo "</div>";
                    echo "<div class=\"right-div\">";
                    echo "<h2>Zdravotní údaje</h2>";
                }
                echo "<p class=\"info\">$czname</p>";
                echo "<input class=\"input_field\" value=\"\" type=\"text\" name=\"$dbname\" size=\"25\">";
                $i++;
            }
            $db = null;

            echo "</div>";
            echo "</div>";
        }

        public function submit_tlacitko()
        {

        }

        public function zobrazeni_tlacitek()
        {
            echo "<div class=\"buttons-div\">";
            echo "<div>";
            echo "<form action=\"ucet_add_patient.php\" method=\"post\">";
            echo "<button type=\"submit\">Přidat pacienta</button>";
            echo "</form>";
            echo "</div>";
            echo "<div>";
            echo "<form action=\"ucet_edit_patient.php\" method=\"post\">";
            echo "<button type=\"submit\">Upravit pacienta</button>";
            echo "</form>";
            echo "</div>";
            echo "<div>";
            echo "<form action=\"ucet_delete_patient.php\" method=\"post\">";
            echo "<button type=\"submit\">Smazat pacienta</button>";
            echo "</form>";
            echo "</div>";
            echo "</div>";
        }
    }

?>
