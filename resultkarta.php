<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karta</title>
    <link rel="stylesheet" href="karta.css">
</head>
<body>

<?php
    //potřebné soubory
    require("page.php");
    require("karta_class.php");

    //generování stránky
    $domovska_stranka = new stranka();
    $obsah = new karta();

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
        
        //uložím hodnoty odpovídajících sloupců
        $values = array($jmeno, $prijmeni, $id, $tel, $mail, $zeme, $mesto, $psc, $ulice, $cp,
                        $vaha, $vyska, $kr_skupina, $chr_n, $ale_n, $gen_n, $ded_n
                       );
    }

    $domovska_stranka->obsah = $obsah->zobrazeni_karty($values, "$jmeno $prijmeni rč. $id");

    $domovska_stranka->zobrazeni_stranky();
?>