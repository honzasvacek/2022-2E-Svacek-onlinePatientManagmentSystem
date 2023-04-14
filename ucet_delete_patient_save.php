<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Účet - odebrání</title>
    <link rel="stylesheet" href="ucet.css">
</head>
<body>

<?php
    //potřebné soubory
    require("page.php");
    require("ucet_obsah.php");

    class ucet_delete_patient_save extends ucet_obsah
    {
        //upravení dědičných funkcí

        public function poslani_dat($data)
        {
            //vytvořím pole, kam budu ukládat nevyplněné hodnoty
            $errors = array();
            
            if(($_SERVER['REQUEST_METHOD'] == "POST"))
            {
                @$id = trim($_POST['identification_number']);

                //zda splňuje parametry
                if(!((strlen($id) == 10) && ((intval($id) % 11) == 0) && (is_numeric($id))))
                {
                    //rodné číslo neodpovídá parametrům, takže vypíšu zprávu a skončím
                    ?>
                        <div class="popup-image">
                            <div class="message">
                                <span>&times;</span> <!-- html entita, která vytvoří symbol křížku -->
                                <h2>Smazání - Neúspěšné</h2>
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

                if(mysqli_connect_errno() != 0)
                {
                    //spojení se nepodařilo, protože funkce vrátila číslo různé od nuly => číslo chyby
                    echo '<p> Nepodařilo se navázat spojení s databází </p>';
                    exit;
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
                    return false;
                }
                if(empty($id_from_db))
                {
                    //uživatel hledá pacienta, který neexistuje

                    ?>
                        <div class="popup-image">
                            <div class="message">
                                <span>&times;</span> 
                                <h2>Smazání - Neúspěšné</h2>
                                <p id="id_exist_p">*Pacient s vyplněným rodným číslem neexistuje</p>
                            </div>
                        </div>
                        <script>
                            //zobrazení popupu
                            document.querySelector('.popup-image').style.display = 'block';
                        </script>
                    <?php
                    return false;
                }

                //mazání pacienta
                $query = "DELETE FROM patient_account WHERE identification_number = $id";
                $stmt = $db->prepare($query);
                $stmt->execute();

                //vypsání zprávy
                ?>
                <div class="popup-image">
                    <div class="message">
                        <span>&times;</span> 
                        <h2>Smazání - Úspěšné</h2>
                        <p>
                            Údaje byly smazány
                        </p>
                    </div>
                </div>
                <script>document.querySelector('.popup-image').style.display = 'block';</script>
            <?php

                //odpojení od databáze
                $db = null;

            }   
        }
    }

    //vypsání obsahu
    $domovska_stranka = new stranka();
    $ucet_obsah = new ucet_delete_patient_save();

    $domovska_stranka->obsah =$ucet_obsah->ucet_obsah("Smazání pacienta", "ucet_edit_patient_save.php");

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

</body>