<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karta</title>
    <link rel="stylesheet" href="karta.css">
    <link rel="stylesheet" href="popup_message/popup_styles.css">

</head>
<body>

<?php
    //potřebné soubory
    require_once($_SERVER['DOCUMENT_ROOT'].'/Page/page.php');
    require("karta_class.php");
    require_once($_SERVER['DOCUMENT_ROOT'].'/Page/functions.php');

    //generování stránky
    $domovska_stranka = new stranka();
    $obsah_karty = new karta();

    //příprava parametrů
    $values = ziskani_hodnot_databaze();
    $titel = "$values[0] $values[1] rč.$values[2]";
    if(getAge($values[2], $values[3]) < 15)
    {
        $contacts = array("Telefonní číslo zákonného zástupce", "E-mail zákonného zástupce");
    } else{
        $contacts = array("Telefonní číslo", "E-mail");
    }
    

    $domovska_stranka->obsah = $obsah_karty->zobrazeni_karty($values, $titel, $contacts);
    $domovska_stranka->zobrazeni_stranky();

    
    function ziskani_hodnot_databaze()
    {
        //získání hodnot z databáze
        if($_SERVER['REQUEST_METHOD'] == "POST")
        {
            //uložím si rodné číslo hledaného pacienta
            $id = trim($_POST['rodne_cislo']);

            //spojení na databázi
            @$db = new mysqli('localhost', 'root', '', 'svacekhealth');
            
            if(mysqli_connect_errno() != 0)
            {
                //spojení se nepodařilo, protože funkce vrátila číslo různé od nuly => číslo chyby
                echo '<p> Nepodařilo se navázat spojení s databází </p>';
                exit;
            }
            
            //zkontroluju jestli je rodné číslo typu int
            if(!is_numeric($id))
            {
                //uživatel zadal rodné číslo jinými znaky než číslo

            ?>
                <div class="popup-image">
                    <div class="message">
                        <span>&times;</span> 
                        <h2>Hledání - Neúspěšné</h2>
                        <p id="id_exist_p">*Zadejte rodné číslo ve formátu RRMMDDXXXX</p>
                    </div>
                </div>
                <script>
                    //zobrazení popupu
                    document.querySelector('.popup-image').style.display = 'block';
                </script>
            <?php

            $values = array("","","","","","","","","","","","","","","","","");
            return $values;
            }
            //zkontroluju jestli je rodné číslo v databázi

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
                $values = array("","","","","","","","","","","","","","","","","");
                return $values;
            }
            //zkkontroluji výsledek
            if(empty($id_from_db))
            {
                //uživatel zadal rodné číslo jinými znaky než číslo

                ?>
                <div class="popup-image">
                    <div class="message">
                        <span>&times;</span> 
                        <h2>Hledání - Neúspěšné</h2>
                        <p id="id_exist_p">*Pacient s tímto rodným číslem není v databázi</p>
                    </div>
                </div>
                <script>
                    //zobrazení popupu
                    document.querySelector('.popup-image').style.display = 'block';
                </script>
            <?php

            $values = array("","","","","","","","","","","","","","","","","");
            return $values;
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
            $query = "SELECT sex, weight, height, bloodtype, chronic_diseases, allergic_diseases, genetic_diseases, hereditary_diseases
            FROM medical_detail WHERE identification_number = $id";
            $stmt = $db->prepare($query);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($pohlavi, $vaha, $vyska, $kr_skupina, $chr_n, $ale_n, $gen_n, $ded_n);
            $stmt->fetch();

            $pohlavi = getSex($pohlavi);
            $vek = getAge($id, $pohlavi);

            
            //uložím hodnoty odpovídajících sloupců
            $values = array($jmeno, $prijmeni, $id, $pohlavi, $vek, $tel, $mail, $zeme, $mesto, $psc, $ulice, $cp,
                            $vaha, $vyska, $kr_skupina, $chr_n, $ale_n, $gen_n, $ded_n
                        );
            return $values;
        }
    }

    
?>
    <script>
        //nastavím spanu, což je křížek, akci on
    document.querySelector('.popup-image span').onclick = () =>
    {
        document.querySelector('.popup-image').style.display = 'none';
    }
    </script>

</body>