<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uložení přidaného pacienta</title>
    <link rel="stylesheet" href="ucet.css">
</head>
<body>

<?php
    //potřebné soubory
    require("page.php");
    require("ucet_obsah.php");

    class ucet_add_patient_save extends ucet_obsah
    {
        public $errors = array(); //vytvořím pole, kam budu ukládat nevyplněné hodnoty


        public function poslani_dat($data)
        {
            if(($_SERVER['REQUEST_METHOD'] == "POST"))
            {
                $errors = array();

                //údaje byly postnuty
                foreach($data as $dbname => $czname)
                {
                    //kontroluju, jestli jsou všechny pole vyplněná
                    @$x = $_POST["$dbname"];
                    
                    if(empty($x))
                    {
                        if(($dbname != "chronic_diseases") && ($dbname != "allergic_diseases") && ($dbname != "genetic_diseases") && ($dbname != "hereditary_diseases"))
                        {
                            //povinný údaj nebyl vyplněn
                            $errors[$czname] = "$czname nebylo vyplněno";
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
                    //připojení na databázi
                    $db = new mysqli('localhost', 'root', '', 'svacekhealth');

                    //vytvářím zkrácené názvy proměnných pro tabulku contact
                    @$id = $_POST['identification_number'];

                    //zkontroluju, zda rodné číslo splňuje parametry rodného čísla
                    if(!((strlen($id) == 10) && ((intval($id) % 11) == 0) && (is_numeric($id))))
                    {
                        //rodné číslo neodpovídá parametrům, takže vypíšu zprávu a skončím
                        ?>
                            <div class="popup-image">
                                <div class="message">
                                    <span>&times;</span> <!-- html entita, která vytvoří symbol křížku -->
                                    <h2>Odeslání - Neúspěšné</h2>
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
                    
                    //zjistím zda náhodou daný pacient již neexistuje

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
                    if(!empty($id_from_db))
                    {
                        if($id_from_db == $id)
                        {
                            //uživatel chtěl přidat pacienta, který již existuje

                            ?>
                                <div class="popup-image">
                                    <div class="message">
                                        <span>&times;</span> 
                                        <h2>Odeslání - Neúspěšné</h2>
                                        <p id="id_exist_p">*Pacient s vyplněným rodným číslem již existuje</p>
                                    </div>
                                </div>
                                <script>
                                    //zobrazení popupu
                                    document.querySelector('.popup-image').style.display = 'block';

                                    //změnění textu paragraphu
                                    /*
                                    const message = "<?//echo "Pacient s rodným číslem $id_from_db už existuje" ?>";
                                    const p = document.getElementById('id_exist_p');
                                    p.innerText = message;*/
                                </script>
                            <?php
                            return 0;
                        }
                    }
                   

                    //zkontroluju zda jsou ostatní proměnné správného typu (string, int)

                    $surname = $_POST['surname'];
                    $lastname = $_POST['lastname'];

                    //kontrola rodneho cisla
                    //1) !empty($rodnecislo_post)) && (strlen($rodnecislo_post) == 10) && ((intval($rodnecislo_post) % 11) == 0)
                    //2) Je v databázi?

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
        }
    }

    //vypsání obsahu
    $domovska_stranka = new stranka();
    $ucet_obsah = new ucet_add_patient_save();

    $domovska_stranka->obsah =$ucet_obsah->ucet_obsah("Přidání pacienta", "ucet_add_patient.php");

    $domovska_stranka->zobrazeni_stranky();
    ?>
        <script>
            //nastavím spanu, což je křížek, akci onclick
            document.querySelector('.popup-image span').onclick = () =>
            {
                //když se spustí onclick schovám popup
                document.querySelector('.popup-image').style.display = 'none';
            }
        </script>
    <?php
?>
</body>

