<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Účet - uložení úprav</title>
    <link rel="stylesheet" href="ucet.css">
    <link rel="stylesheet" href="../Page/popup.css">
</head>
<body>

<?php
    //potřebné soubory
    require($_SERVER['DOCUMENT_ROOT'].'/Page/page.php');
    require($_SERVER['DOCUMENT_ROOT'].'/Page/functions.php');
    require("ucet_obsah.php");

    class ucet_edit_patient_save extends ucet_obsah
    {
        public function poslani_dat($data)
        {

            //vytvořím pole, kam budu ukládat nevyplněné hodnoty
            $errors = array();
            
            if(($_SERVER['REQUEST_METHOD'] == "POST"))
            {
                
                //údaje byly postnuty
                foreach($data as $dbname => $czname)
                {
                    //kontroluju, jestli jsou všechny pole vyplněná
                    @$x = $_POST["$dbname"];
                    
                    if(empty($x))
                    {
                        if(($dbname != "chronic_diseases") && ($dbname != "allergic_diseases") && ($dbname != "genetic_diseases") && ($dbname != "hereditary_diseases") && (strval($_POST[$dbname]) != "0"))
                        {
                            //povinný údaj nebyl vyplněn

                            $errors[$czname] = "$czname nebylo vyplněno";
                        }
                    }
                }
                foreach($errors as $inputname => $err_msg)
                {
                    //když nebyl vyplněn povinný údaj vypíšu zprávu a poté vrátím 0 protože nechci posílat dat do databáze

                    err_msg("Odeslání - Neúspěšné", "Zapomněli jste vyplnit některé povinné údaje");
                    return 0;
                }
                //vše bylo vyplněno

                try
                {
                    $db = connect_to_database();

                    @$id = $_POST['identification_number'];

                    if(patientExist($id) == false)
                    {
                        //Pacient neexistuje v databázi

                        err_msg("Upravení - Neúspěšné", "Pacient s vyplněným rodným číslem neexistuje");
                    }

                    //kontrola, zda rodné číslo existuje
                    $values = array(
                        'surname', 'lastname', 'sex', 'telefon_number', 'email', 'country', 'city', 'zip_code', 'street', 
                        'house_number', 'weight', 'height', 'blood_type', 'chronic_diseases', 'allergic_diseases',
                        'genetic_diseases', 'hereditary_diseases'
                    );

                    //dynamické vytvroření proměnných
                    foreach($values as $value)
                    {
                        ${$value} = htmlspecialchars(trim($_POST[$value]));
                    }

                    //zapsání dat do databáze do tabulky patient_account
                    $query = "UPDATE patient_account SET surname = ?, lastname  = ? WHERE identification_number = $id";
                    $stmt = $db->prepare($query);
                    $stmt->bind_param('ss',$surname, $lastname);
                    $stmt->execute();

                    //zapsání dat do databáze do tabulky contact
                    $query = "UPDATE contact SET telefon_number = ?, email = ?, country = ?, city = ?, zip_code = ?, street = ?, house_number = ? WHERE  identification_number = $id";
                    $stmt = $db->prepare($query);
                    $stmt->bind_param('isssisi',$telefon_number, $email, $country, $city, $zip_code, $street, $house_number);
                    $stmt->execute();			

                    //zapsání dat do databáze do tabulky medical_detail
                    $query = "UPDATE medical_detail SET sex = ?, weight = ?, height = ?, bloodtype = ?, chronic_diseases = ?, allergic_diseases = ?,
                    genetic_diseases = ?, hereditary_diseases = ? WHERE  identification_number = $id";
                    $stmt = $db->prepare($query);
                    $stmt->bind_param('iddsssss',$sex, $weight, $height, $blood_type, $chronic_diseases, $allergic_diseases, $genetic_diseases, $hereditary_diseases);
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

            // Všechno porběhlo v pořádku => vypíši zprávu, že všechno proběhlo dobře 
            
            err_msg("Upravení - Úspěšné", "Údaje byly úspěšně upraveny");
        }
        

        /*public function dynamicke_zobrazeni_policek($arr)
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
        }*/
    }

     //vypsání obsahu
     $domovska_stranka = new stranka();
     $ucet_obsah = new ucet_edit_patient_save();
 
     $domovska_stranka->obsah =$ucet_obsah->ucet_obsah("Pacient", "ucet_edit_patient_save.php");
 
     $domovska_stranka->zobrazeni_stranky(false);
    ?>        
</body>
</html>
        