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

    class ucet_delete_patient extends ucet_obsah
    {
        public function zobrazeni_tlacitek()
        {
            
        }

        public function submit_tlacitko()
        {
            echo "<div style=\"border-top: 0.5px solid gray;\" class=\"buttons-div\">";
            echo "<input class=\"submit-button\" type=\"submit\" value=\"Smazat\">";  
            echo "</div>"; 
        }

        public function kontrola_rodneho_cisla()
        {
            //prvně zkontroluju zda uživatel něco postnul, pokud ne nebudu nic kontrolvat

            //získání vstupu uživatele
            @$id = htmlspecialchars(trim($_POST['rodne_cislo']));

            if(empty($id))
            {
                //uživatel nic nevyplnil
                return false;
            }

            //spojení na databázi
            @$db = new mysqli('localhost', 'root', '', 'svacekhealth');
            if(mysqli_connect_errno() != 0)
            {
                //spojení se nepodařilo, protože funkce vrátila číslo různé od nuly => číslo chyby
                echo '<p> Nepodařilo se navázat spojení s databází </p>';
                return false;
            }
            //zkontrolání formátu rodného čísla - jestli má vůbec cenu ho hledat v databázi

            if(!((strlen($id) == 10) && ((intval($id) % 11) == 0) && (is_numeric($id))))
            {
                //rodné číslo neodpovídá parametrům, takže vypíšu zprávu a skončím
                ?>
                    <div class="popup-image">
                        <div class="message">
                            <span>&times;</span> <!-- html entita, která vytvoří symbol křížku -->
                            <h2>Hledání - Neúspěšné</h2>
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
                return false;
            }

            //zkontrolování, zda je rondné číslo v databázi

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
                //uživatel chtěl přidat pacienta, který již existuje

                ?>
                    <div class="popup-image">
                        <div class="message">
                            <span>&times;</span> 
                            <h2>Hledání - Neúspěšné</h2>
                            <p>*Pacient s vyplněným rodným číslem neexistuje</p>
                        </div>
                    </div>
                    <script>
                        //zobrazení popupu
                        document.querySelector('.popup-image').style.display = 'block';
                    </script>
                <?php
                return false;
            }
            //když se nikde nevrátilo false znamenáto, že je vše ok
            return true;
        }

        public function dynamicke_zobrazeni_policek($arr)
        {
            @$id = trim($_POST['rodne_cislo']);
            
            if(!empty($id))
            {
                //získání vstupu uživatele
                $id = htmlspecialchars(trim($_POST['rodne_cislo']));


                //spojení na databázi
                @$db = new mysqli('localhost', 'root', '', 'svacekhealth');
                if(mysqli_connect_errno() != 0)
                {
                    //spojení se nepodařilo, protože funkce vrátila číslo různé od nuly => číslo chyby
                    echo '<p> Nepodařilo se navázat spojení s databází </p>';
                    exit;
                }
                //zkontrolání formátu rodného čísla - jestli má vůbec cenu ho hledat v databázi

                if(!((strlen($id) == 10) && ((intval($id) % 11) == 0) && (is_numeric($id))))
                {
                    //rodné číslo neodpovídá parametrům, takže vypíšu zprávu a skončím
                    ?>
                        <div class="popup-image">
                            <div class="message">
                                <span>&times;</span> <!-- html entita, která vytvoří symbol křížku -->
                                <h2>Hledání - Neúspěšné</h2>
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

                //zkontrolování, zda je rondné číslo v databázi

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
                    //uživatel chtěl přidat pacienta, který již existuje

                    ?>
                        <div class="popup-image">
                            <div class="message">
                                <span>&times;</span> 
                                <h2>Hledání - Neúspěšné</h2>
                                <p>*Pacient s vyplněným rodným číslem neexistuje</p>
                            </div>
                        </div>
                        <script>
                            //zobrazení popupu
                            document.querySelector('.popup-image').style.display = 'block';
                        </script>
                    <?php
                    return 0;
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
            }
        }
    }

    //vypsání obsahu
    $domovska_stranka = new stranka();
    $ucet_obsah = new ucet_delete_patient();

    $domovska_stranka->obsah =$ucet_obsah->ucet_obsah("Smazání pacienta", "ucet_delete_patient_save.php");
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
