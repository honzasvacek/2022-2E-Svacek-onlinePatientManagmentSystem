<?php
    class ucet_obsah
    {
        public $pole_jmena = array("Jméno", "Příjmení", "Rodné číslo", 
                                   "Telefonní číslo", "E-mail", "Země",
                                   "Město", "Poštovní směrovací číslo",
                                    "Ulice", "Číslo popisné" ,"Váha",
                                     "Výška", "Krevní skupina", "Chronické nemoci",
                                    "alergie", "genetické nemoci", "dědičné nemoci");
        
        public $pole_hodnoty = array( "surname", "lastname", "identification_number",
                                      "weight", "height", "blood_type", "chronic_diseases",
                                    "allergic_diseases", "genetic_diseases", "hereditary_diseases",
                                       "telefon_number", "email", "country", "city",
                                        "zip_code", "street", "house_number"
                                    );
        

        public function ucet_obsah($title){
            echo "<div class=\"container\">";
            $this->zobrazeni_obsahu_uctu($title);
            $this->upravovani_uctu();
            echo "</div>";
        }

        public function poslani_dat($pole_hodnoty)
            {
                if($_SERVER['REQUEST_METHOD'] == "POST")
                {
                    //údaje byly postnuty
                    foreach($pole_hodnoty as $hodnota)
                    {
                        //kontroluju, jestli jsou všechny pole vyplněná
                        @$x = $_POST["$hodnota"];
                        if(empty($x) && !($hodnota == "chronic_diseases" || $hodnota == "allergic_diseases" || $hodnota == "genetic_diseases" || $hodnota == "hereditary_diseases"))
                        {
                            //uživatel něco nevyplnil
                            echo "</br><p>Nevyplnili jste všechny povinné údaje</p>";
                            echo "<div class=\"popup\" id=\"popup\">";
                            echo "<h2>Odeslání - neúspěšné</h2>";
                            echo "<p>Údaje nebyly uloženy - nevyplnili jste všechny povinné údaje</p>";
                            echo "<input class=\"createAccBtn\" type=\"button\" value=\"OK\" onclick=\"closePopup()\"/>"; //zavře popup
                            echo "</div>";
                            echo "<script type=\"text/javascript\">open_popup();</script>";
                            return 0; //pokud nebylo vše vyplněno, vypíšu zprávu a skončím
                        }
                    }
                    //vše bylo vyplněno
                    
                    try
                    {
                        //připojení na databázi
                        $db = new mysqli('localhost', 'root', '', 'svacekhealth');

                        //vytvářím zkrácené názvy proměnných pro tabulku contact
                        $id = $_POST['identification_number'];
                        $surname = $_POST['surname'];
                        $lastname = $_POST['lastname'];

                        //zapsání dat do databáze do tabulky patient_account
                        $query = "INSERT INTO patient_account (identification_number, surname, lastname) VALUES(?, ?, ?)";
                        $stmt = $db->prepare($query);
                        $stmt->bind_param('iss', $id, $surname, $lastname);
                        $stmt->execute();

                        //vytvářím zkrácené názvy proměnných pro tabulku contact
                        $telefon_number = $_POST['telefon_number'];
                        $email = $_POST['email'];
                        $country = $_POST['country'];
                        $city = $_POST['city'];
                        $zip_code = $_POST['zip_code'];
                        $street = $_POST['street'];
                        $house_number = $_POST['house_number'];

                        //zapsání dat do databáze do tabulky contact
                        $query = "INSERT INTO contact VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
                        $stmt = $db->prepare($query);
                        $stmt->bind_param('iisssisi',$id, $telefon_number, $email, $country, $city, $zip_code, $street, $house_number);
                        $stmt->execute();

                        //vytvářím zkrácené názvy proměnných pro tabulku contact
                        $weight = $_POST['weight'];	
                        $height	= doubleval($_POST['height']);
                        $blood_type = doubleval($_POST['blood_type']);
                        $chronic_diseases = $_POST['chronic_diseases'];	
                        $allergic_diseases = $_POST['allergic_diseases'];	
                        $genetic_diseases = $_POST['genetic_diseases'];	
                        $hereditary_diseases = $_POST['hereditary_diseases'];	

                        //zapsání dat do databáze do tabulky medical_detail
                        $query = "INSERT INTO medical_detail VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
                        $stmt = $db->prepare($query);
                        $stmt->bind_param('iddsssss',$id, $weight, $height, $blood_type, $chronic_diseases, $allergic_diseases, $genetic_diseases, $hereditary_diseases);
                        $stmt->execute();

                        //odpojení od databáze 
                        $db = null;
                    } catch(PDOException $err)
                      {
                          //chycení vyjímky
                          echo "Došlo k chybě: ".$err->getMessage();
                          return 0;
                      }
                }
            }
        
        public function zobrazeni_obsahu_uctu($title)
        {
            echo "<form action=\"\" method=\"post\">";
            echo "<div class=\"account_form\">";
            echo "<div class=\"header_div\"><h1 class=\"headline\">$title<h1></div>";
            echo "<div class=\"left_right_container\">";
            echo "<div class=\"left_container\">";
            echo "<p class=\"info\">Jméno</p>";
            echo "<input class=\"input_field\" type=\"text\" name=\"surname\" size=\"25\">";
            echo "<p class=\"info\">Příjmení</p>";
            echo "<input class=\"input_field\" type=\"text\" name=\"lastname\" size=\"25\">";
            echo "<p class=\"info\">Rodné číslo</p>";
            echo "<input class=\"input_field\" type=\"text\" name=\"identification_number\" size=\"25\">";
            echo "<p class=\"info\">Telefonní číslo</p>";
            echo "<input class=\"input_field\" type=\"text\" name=\"telefon_number\" size=\"25\">";
            echo "<p class=\"info\">E-mail</p>";
            echo "<input class=\"input_field\" type=\"text\" name=\"email\" size=\"25\" maxlength=\"50\" value=\"\">";
            echo "<p class=\"info\">Země</p>";
            echo "<input class=\"input_field\" type=\"text\" name=\"country\" size=\"25\" maxlength=\"50\">";
            echo "<p class=\"info\">Město</p>";
            echo "<input class=\"input_field\" type=\"text\" name=\"city\" size=\"25\" maxlength=\"50\">";
            echo "<p class=\"info\">Poštovní směrovací číslo</p>";
            echo "<input class=\"input_field\" type=\"text\" name=\"zip_code\" size=\"25\">";
            echo "<p class=\"info\">Ulice</p>";
            echo "<input class=\"input_field\" type=\"text\" name=\"street\" size=\"25\" maxlength=\"100\">";
            echo "<p class=\"info\">Číslo popisné</p>";
            echo "<input class=\"input_field\" type=\"text\" name=\"house_number\" size=\"25\">";
            echo "</div>";
            echo "<div class=\"right_container\">";
            echo "<p class=\"info\">Váha</p>";
            echo "<input class=\"input_field\" type=\"text\" name=\"weight\" size=\"25\">";
            echo "<p class=\"info\">Výška</p>";
            echo "<input class=\"input_field\" type=\"text\" name=\"height\" size=\"25\">";
            echo "<p class=\"info\">Krevní skupina</p>";
            echo "<input class=\"input_field\" type=\"text\" name=\"blood_type\" size=\"25\" maxlength=\"30\">";
            echo "<p class=\"info\">Chronické nemoci</p>";
            echo "<input class=\"input_field\" type=\"text\" name=\"chronic_diseases\" size=\"25\" maxlength=\"100\">";
            echo "<p class=\"info\">Alergie</p>";
            echo "<input class=\"input_field\" type=\"text\" name=\"allergic_diseases\" size=\"25\" maxlength=\"100\">";
            echo "<p class=\"info\">Genetické nemoci</p>";
            echo "<input class=\"input_field\" type=\"text\" name=\"genetic_diseases\" size=\"25\" maxlength=\"100\">";
            echo "<p class=\"info\">Dědičné nemoci</p>";
            echo "<input class=\"input_field\" type=\"text\" name=\"hereditary_diseases\" size=\"25\" maxlength=\"100\">";
            echo "<input class=\"createAccBtn\" type=\"submit\" value=\"Přidat pacienta\" onclick=\"open_popup()\"/>"; //zobrazí popup

            $this->poslani_dat($this->pole_hodnoty);

            echo "</div>";
            echo "</div>";
            echo "</form>";
            echo "</div>";
            //popup
            echo "<div class=\"popup\" id=\"popup\">";
            echo "<h2>Odeslání - úspěšné</h2>";
            echo "<p>Údaje byly uloženy</p>";
            echo "<input class=\"createAccBtn\" type=\"button\" value=\"OK\" onclick=\"close_popup()\"/>"; //zavře popup
            echo "</div>";
            echo "<script type=\"text/javascript\">open_popup();</script>";
        }

        public function upravovani_uctu() {
            echo "<div class=\"account_form\">";
            echo "<div class=\"header_div\"><h1 class=\"headline\">Pacient<h1></div>";
            echo "</div>";
        }

    }

?>
<script type="text/javascript">
    //javascript pro zobrazení popupu
    let popup = document.getElementById("popup");
    function open_popup()
    {
        //zobrazí popup
        popup.classList.add("open_popup"); //přídám css třídu open_popup
        window.print("KOX");
    }

    function close_popup()
    {
        //schová popup
        popup.classList.remove("open_popup"); //odebere css třídu open_popup
    }
</script>