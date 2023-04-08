<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Účet - uložení úprav</title>
    <link rel="stylesheet" href="ucet.css">
</head>
<body>

<?php
    //potřebné soubory
    require("page.php");
    require("ucet_obsah.php");

    class ucet_edit_patient_save extends ucet_obsah
    {
        public function poslani_dat($data)
        {
            //pokud uživatel vyhledává pacienta nechci zpouštět tuto if klausuli
            @$rodne_cislo_post = trim($_POST['rodne_cislo']);
            
            if(($_SERVER['REQUEST_METHOD'] == "POST") && (empty($rodne_cislo_post)))
            {
                echo "start";
                //údaje byly postnuty
                foreach($data as $dbname => $czname)
                {
                    //kontroluju, jestli jsou všechny pole vyplněná
                    @$x = $_POST["$dbname"];
                    if(empty($x) && !($dbname == "chronic_diseases" || $dbname == "allergic_diseases" || $dbname == "genetic_diseases" || $dbname == "hereditary_diseases"))
                    {
                        //uživatel něco nevyplnil
                        //popup
                        echo "NIC";
                        //return 0; //pokud nebylo vše vyplněno, vypíšu zprávu a skončím
                    }
                }
                //vše bylo vyplněno

                try
                {
                    //popup
                    echo "OK";
                    //připojení na databázi
                    $db = new mysqli('localhost', 'root', '', 'svacekhealth');

                    //vytvářím zkrácené názvy proměnných pro tabulku contact
                    $id = $_POST['identification_number'];
                    $surname = $_POST['surname'];
                    $lastname = $_POST['lastname'];

                    //zapsání dat do databáze do tabulky patient_account
                    $query = "UPDATE patient_account SET surname = ?, lastname  = ? WHERE identification_number = $id";
                    $stmt = $db->prepare($query);
                    $stmt->bind_param('ss',$surname, $lastname);
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
                    $query = "UPDATE contact SET telefon_number = ?, email = ?, country = ?, city = ?, zip_code = ?, street = ?, house_number = ? WHERE  identification_number = $id";
                    $stmt = $db->prepare($query);
                    $stmt->bind_param('isssisi',$telefon_number, $email, $country, $city, $zip_code, $street, $house_number);
                    $stmt->execute();

                    //vytvářím zkrácené názvy proměnných pro tabulku contact
                    $weight = doubleval($_POST['weight']);	
                    $height	= doubleval($_POST['height']);
                    $blood_type = $_POST['blood_type'];
                    @$chronic_diseases = $_POST['chronic_diseases'];	
                    @$allergic_diseases = $_POST['allergic_diseases'];	
                    @$genetic_diseases = $_POST['genetic_diseases'];	
                    @$hereditary_diseases = $_POST['hereditary_diseases'];
                    if(empty($allergic_diseases))
                    {
                        $allergic_diseases = "";
                    }
                    if(empty($chronic_diseases))
                    {
                        $chronic_diseases = "";
                    }
                    if(empty($genetic_diseases))
                    {
                        $genetic_diseases = "";
                    }	
                    if(empty($hereditary_diseases))
                    {
                        $hereditary_diseases = "";
                    }			

                    //zapsání dat do databáze do tabulky medical_detail
                    $pomocna_promena = "weight";
                    $query = "UPDATE medical_detail SET $pomocna_promena = ?, height = ?, bloodtype = ?, chronic_diseases = ?, allergic_diseases = ?,
                    genetic_diseases = ?, hereditary_diseases = ? WHERE  identification_number = $id";
                    $stmt = $db->prepare($query);
                    $stmt->bind_param('ddsssss', $weight, $height, $blood_type, $chronic_diseases, $allergic_diseases, $genetic_diseases, $hereditary_diseases);
                    $stmt->execute();

                    //odpojení od databáze 
                    $db = null;
                } catch(PDOException $err)
                    {
                        //chycení vyjímky
                        echo "Došlo k chybě: ".$err->getMessage();
                        return 0;
                    }
                //popup
            } else
            {
                return 0;
            }
        }
    }

     //vypsání obsahu
     $domovska_stranka = new stranka();
     $ucet_obsah = new ucet_edit_patient_save();
 
     $domovska_stranka->obsah =$ucet_obsah->ucet_obsah("Pacient", "ucet_edit_patient_save.php");
 
     $domovska_stranka->zobrazeni_stranky();
?>
</body>
        