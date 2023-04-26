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
    require_once($_SERVER['DOCUMENT_ROOT'].'/Page/page.php');
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
                            //echo $this->errors[$czname];
                        }
                    }
                }
                foreach($errors as $inputname => $err_msg)
                {
                    //když nebyl vyplněn povinný údaj vypíšu zprávu a poté vrátím 0 protože nechci posílat dat do databáze
                    ?>
                    <div class="popup-image">
                        <div class="message">
                            <span>&times;</span> <!-- html entita, která vytvoří symbol křížku -->
                            <h2>Odeslání - Neúspěšné</h2>
                            <p>
                                *Zapomněli jste vyplnit některé povinné údaje
                            </p>
                        </div>
                    </div>
                    <script>document.querySelector('.popup-image').style.display = 'block';</script>
                    <?php
                    return 0;
                }
                //vše bylo vyplněno

                try
                {
                    @$id = $_POST['identification_number'];

                    //zda splňuje parametry
                    if(!((strlen($id) == 10) && ((intval($id) % 11) == 0) && (is_numeric($id))))
                    {
                        //rodné číslo neodpovídá parametrům, takže vypíšu zprávu a skončím
                        ?>
                            <div class="popup-image">
                                <div class="message">
                                    <span>&times;</span> <!-- html entita, která vytvoří symbol křížku -->
                                    <h2>Upravení - Neúspěšné</h2>
                                    <p style="margin-bottom: 0;">
                                        *Zkontrolujte prosím znovu, zda jste zadali rodné číslo správně. 
                                    </p>
                                    <p>
                                    Parametry rodného čísla nejsou správné
                                    </p>
                                </div>
                            </div>
                            <script>document.querySelector('.popup-image').style.display = 'block';</script>
                        <?php
                        return 0;
                    }

                    //pokud splňuje parametry, tak zjistím, zda rodné číslo existuje

                    //připojení na databázi
                    $db = new mysqli('localhost', 'root', '', 'svacekhealth');

                    //připravím dotaz
                    $query = "SELECT identification_number FROM patient_account WHERE identification_number = $id";

                    try
                    {
                        //zkusím provést příkaz

                        $stmt = $db->prepare($query);
                        $stmt->execute();
                        $stmt->store_result();
                        $stmt->bind_result($id_from_db);
                        $stmt->fetch();
                    }
                    catch(PDOException $err)
                    {
                        //pokud rodné číslo neexistuje zachytím vyjímku

                        echo $err->getMessage();
                        return 0;
                    }
                    if(empty($id_from_db))
                    {
                        //uživatel hledá pacienta, který neexistuje

                        ?>
                            <div class="popup-image">
                                <div class="message">
                                    <span>&times;</span> 
                                    <h2>Upravení - Neúspěšné</h2>
                                    <p id="id_exist_p">*Pacient s vyplněným rodným číslem neexistuje</p>
                                </div>
                            </div>
                            <script>
                                //zobrazení popupu
                                document.querySelector('.popup-image').style.display = 'block';
                            </script>
                        <?php
                        return 0;
                    }

                    //kontrola, zda rodné číslo existuje

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
              
            } 
            ?>
            <!-- Všechno porběhlo v pořádku => vypíši zprávu, že všechno proběhlo dobře -->
                <div class="popup-image">
                    <div class="message">
                        <span>&times;</span> <!-- html entita, která vytvoří symbol křížku -->
                        <h2>Odeslání - Úspěšné</h2>
                        <p>
                            Údaje byly upraveny a uloženy
                        </p>
                    </div>
                </div>
                <script>document.querySelector('.popup-image').style.display = 'block';</script>
            <?php
        }
        

        public function dynamicke_zobrazeni_policek($arr)
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
        }
    }

     //vypsání obsahu
     $domovska_stranka = new stranka();
     $ucet_obsah = new ucet_edit_patient_save();
 
     $domovska_stranka->obsah =$ucet_obsah->ucet_obsah("Pacient", "ucet_edit_patient_save.php");
 
     $domovska_stranka->zobrazeni_stranky(false);
    ?>        
</body>
</html>
        