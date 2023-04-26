<?php
    class ucet_obsah
    {
        public $data = array("surname" => "Jméno", "lastname" => "Příjmení", "identification_number" => "Rodné číslo", "sex" => "Pohlaví",
                             "telefon_number"  => "Telefonní číslo", "email"  => "E-mail", "country"  => "Země" ,
                             "city"  => "Město", "zip_code"  => "Poštovní směrovací číslo", "street"  => "Ulice", "house_number"  => "Číslo popisné", 
                             "weight" => "Váha", "height" => "Výška", "blood_type"  => "Krevní skupina", 
                             "chronic_diseases"  => "Chronické nemoci", "allergic_diseases"  => "Alergie",
                             "genetic_diseases"  => "Genetické nemoci", "hereditary_diseases"  => "Dědičné nemoci"
                            );

        public function ucet_obsah($title, $action){
            echo "<div class=\"container\">";
            $this->zobrazeni_obsahu_uctu($title, $this->data, $action);
            if($this->kontrola_rodneho_cisla() == true)
            {
                $this->dynamicke_zobrazeni_policek($this->data);
            } else
              {
                  $this->zobrazeni_prazdnych_policek($this->data);
              }
            $db = null;
            echo "</div>";
            echo "</div>";
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
            echo "<form action=\"$action\" method=\"POST\">";
            echo "<div class=\"account_form\">";
            echo "<div class=\"header_div\"><h1 class=\"headline\">$title<h1></div>";
            echo "<div class=\"section-3-div\">";
        }

        public function kontrola_rodneho_cisla()
        {
            // v defaultu vrací false
            return false;
        }

        public function dynamicke_zobrazeni_policek($arr)
        {
            
        }

        public function zobrazeni_prazdnych_policek($arr)
        {
            $i = 0;
            foreach($arr as $dbname => $czname)
            {
                if($i == 0)
                {
                    //chci pritnout první div
                    echo "<div class=\"left-div\">";
                    echo "<h2>Základní údaje</h2>";
                }
                if($i==4)
                {
                    //chci pritnout druhý div a ukončit první
                    echo "</div>";
                    echo "<div class=\"middle-div\">";
                    echo "<h2>Kontakt</h2>";
                }
                if($i==11)
                {
                    //chci pritnout třetí div a ukončit druhý
                    echo "</div>";
                    echo "<div class=\"right-div\">";
                    echo "<h2>Zdravotní údaje</h2>";
                }

                echo "<p class=\"info\">$czname</p>";

                if($i == 3)
                {
                    echo "<select name=\"sex\">
                        <option value=\"null\">Vyberte Pohlaví</option>
                        <option value=\"0\">Žena</option>
                        <option value=\"1\">Muž</option>
                    </select>";
                } else {
                    echo "<input class=\"input_field\" value=\"\" type=\"text\" name=\"$dbname\">";
                }

                $i++;
            }
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
