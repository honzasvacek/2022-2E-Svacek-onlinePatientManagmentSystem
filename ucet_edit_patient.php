<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Účet - upravení</title>
    <link rel="stylesheet" href="ucet.css">
</head>
<body>

<?php
    //potřebné soubory
    require("page.php");
    require("ucet_obsah.php");

    class ucet_edit_patient extends ucet_obsah
    {
        public function zobrazeni_tlacitek()
        {
            
        }

        public function submit_tlacitko()
        {
            echo "<div style=\"border-top: 0.5px solid gray;\" class=\"buttons-div\">";
            echo "<input class=\"submit-button\" type=\"submit\" value=\"Save\">";  
            echo "</div>"; 
        }

        public function zobrazeni_obsahu_uctu($title, $arr, $action)
        {
            @$id = trim($_POST['rodne_cislo']);
            if(empty($id))
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
            else
            {
                //spojení na databázi
                @$db = new mysqli('localhost', 'root', '', 'svacekhealth');
                if(mysqli_connect_errno() != 0)
                {
                    //spojení se nepodařilo, protože funkce vrátila číslo různé od nuly => číslo chyby
                    echo '<p> Nepodařilo se navázat spojení s databází </p>';
                    exit;
                }
                //získáni dat z tabulky - patient_account
                $query = "SELECT surname, lastname FROM patient_account WHERE identification_number = $id";
                $stmt = $db->prepare($query);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($jmeno, $prijmeni);
                $stmt->fetch();

                //získání dat z tabulky - contact
                $query = "SELECT  telefon_number, email, country, city, zip_code, street, house_number
                FROM contact WHERE identification_number = $id";
                $stmt = $db->prepare($query);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($tel, $mail, $zeme, $mesto, $psc, $ulice, $cp);
                $stmt->fetch();

                //získání dat z tabulky - medical_detail
                $query = "SELECT weight, height, bloodtype, chronic_diseases, allergic_diseases, genetic_diseases, hereditary_diseases
                FROM medical_detail WHERE identification_number = $id";
                $stmt = $db->prepare($query);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($vaha, $vyska, $kr_skupina, $chr_n, $ale_n, $gen_n, $ded_n);
                $stmt->fetch();
                //vypsání obsahu
                $i = 0;
                echo "<form action=\"$action\" method=\"post\">";
                echo "<div class=\"account_form\">";
                echo "<div class=\"header_div\"><h1 class=\"headline\">$title<h1></div>";
                echo "<div class=\"section-3-div\">";

                $hodnoty_databaze = array($jmeno, $prijmeni, $id, $tel, $mail,
                                        $zeme, $mesto, $psc, $ulice, $cp,
                                        $vaha, $vyska, $kr_skupina, $chr_n,
                                        $ale_n, $gen_n, $ded_n
                                        );
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
                    echo "<input class=\"input_field\" value=\"$hodnoty_databaze[$i]\" type=\"text\" name=\"$dbname\" size=\"25\">";
                    $i++;
                }
                $db = null;

                echo "</div>";
                echo "</div>";
            }
        }
    }

    //vypsání obsahu
    $domovska_stranka = new stranka();
    $ucet_obsah = new ucet_edit_patient();

    $domovska_stranka->obsah =$ucet_obsah->ucet_obsah("Úprava pacietna", "ucet_edit_patient_save.php");

    $domovska_stranka->zobrazeni_stranky();
?>
</body>