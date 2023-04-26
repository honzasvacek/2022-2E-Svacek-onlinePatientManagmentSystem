<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Účet - upravení</title>
    <link rel="stylesheet" href="ucet.css">
    <link rel="stylesheet" href="../Page/popup.css">
</head>
<body>

<?php
    //potřebné soubory
    require($_SERVER['DOCUMENT_ROOT'].'/Page/page.php');
    require("../Page/functions.php");
    require("ucet_obsah.php");

    class ucet_edit_patient extends ucet_obsah
    {
        public function zobrazeni_tlacitek()
        {
            
        }

        public function submit_tlacitko()
        {
            echo "<div style=\"border-top: 0.5px solid gray;\" class=\"buttons-div\">";
            echo "<input class=\"submit-button\" type=\"submit\" value=\"Uložit úpravy\">";  
            echo "</div>"; 
        }

        public function kontrola_rodneho_cisla()
        {
            @$id = htmlspecialchars(trim($_POST['rodne_cislo']));

            if(!empty($id))
            {
                //připojení na databázi

                $db = connect_to_database();

                //zkontroluju, zda rodné číslo splňuje parametry rodného čísla
                if(parametersID($id) == false)
                {
                    err_msg("Hledání - Neúspěšné","Zkontrolujte prosím znovu, zda jste zadali rodné číslo správně");
                    return false;
                }
                    
                if(patientExist($id) == false)
                {
                    err_msg("Hledání - Neúspěšné","Pacient s vyplněným rodným číslem neexistuje");
                    return false;
                }  
            }
            else
            {
                return false;
            }
            return true; //pokud nic nevrátilo false je vše v pořádku a vrátím true
        }

        public function dynamicke_zobrazeni_policek($arr)
        {
            @$id = trim($_POST['rodne_cislo']);
          
            //spojení na databázi
            $db = connect_to_database();
            
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
            $query = "SELECT sex, weight, height, bloodtype, chronic_diseases, allergic_diseases, genetic_diseases, hereditary_diseases
            FROM medical_detail WHERE identification_number = $id";
            $stmt = $db->prepare($query);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($sex, $vaha, $vyska, $kr_skupina, $chr_n, $ale_n, $gen_n, $ded_n);
            $stmt->fetch();
            //vypsání obsahu
            $i = 0;

            $sex = getSex($sex);

            $hodnoty_databaze = array($jmeno, $prijmeni, $id, $sex, $tel, $mail,
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
                echo "<input class=\"input_field\" value=\"$hodnoty_databaze[$i]\" type=\"text\" name=\"$dbname\" size=\"25\">";
                $i++;
            }
            
        }
    }

    //vypsání obsahu
    $domovska_stranka = new stranka();
    $ucet_obsah = new ucet_edit_patient();

    $domovska_stranka->obsah =$ucet_obsah->ucet_obsah("Úprava pacietna", "ucet_edit_patient_save.php");

    $domovska_stranka->zobrazeni_stranky(true);
?>
</body>
</html>