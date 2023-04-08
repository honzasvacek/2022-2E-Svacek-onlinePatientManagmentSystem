<?php

class karta
    {

        public $data = array("surname" => "Jméno", "lastname" => "Příjmení", "identification_number" => "Rodné číslo",
                            "telefon_number"  => "Telefonní číslo", "email"  => "E-mail", "country"  => "Země" ,
                            "city"  => "Město", "zip_code"  => "Poštovní směrovací číslo", "street"  => "Ulice", "house_number"  => "Číslo popisné",
                            "weight" => "Váha", "height" => "Výška", "blood_type"  => "Krevní skupina", 
                            "chronic_diseases"  => "Chronické nemoci", "allergic_diseases"  => "Alergie",
                            "genetic_diseases"  => "Genetické nemoci", "hereditary_diseases"  => "Dědičné nemoci"
                            );
        
        public function zobrazeni_karty($arr, $title)
        {
            $this->zobrazeni_obsahu_karty($arr, $title);
        }

        public function zobrazeni_obsahu_karty($arr, $title)
        {
            $arr_values = $arr;
            $arr_data = $this->data;
            $i = 0;
            echo "<div class=\"container\">";
            echo "<div class=\"account_form\">";
            echo "<div class=\"header_div\"><h1 class=\"headline\">Karta pacienta - $title<h1></div>";
            echo "<div class=\"section-3-div\">";
            foreach($arr_data as $dbname => $czname)
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
                echo "<input class=\"input_field\" value=\"$arr_values[$i]\" type=\"text\" name=\"$dbname\" size=\"25\">";
                $i++;
            }

            echo "</div>";
            echo "</div>";
            echo "<div class=\"bottom-div\"></div>";
            echo "</div>";
            echo "</div>";
        }
    
    }

?>