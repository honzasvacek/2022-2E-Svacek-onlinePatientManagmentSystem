<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Účet - odebrání</title>
    <link rel="stylesheet" href="ucet.css">
    <link rel="stylesheet" href="../Page/popup.css">
</head>
<body>

<?php
    //potřebné soubory
    require_once($_SERVER['DOCUMENT_ROOT'].'/Page/page.php');
    require("../Page/functions.php");
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

                //pokud splňuje parametry, tak zjistím, zda rodné číslo existuje
                if(patientExist($id) == false)
                {
                    err_msg("Smazání - Neúspěšné", "Pacient není v databázi");
                    return 0;
                }

                $db = connect_to_database();

                //mazání pacienta
                $query = "DELETE FROM patient_account WHERE identification_number = $id";
                $stmt = $db->prepare($query);
                $stmt->execute();

                //vypsání zprávy
                err_msg("Smazání - Úspěšné", "Pacient byl smazán z databáze");

                //odpojení od databáze
                $db = null;

            }   
        }
    }

    //vypsání obsahu
    $domovska_stranka = new stranka();
    $ucet_obsah = new ucet_delete_patient_save();

    $domovska_stranka->obsah =$ucet_obsah->ucet_obsah("Smazání pacienta", "ucet_edit_patient_save.php");

    $domovska_stranka->zobrazeni_stranky(false);
?>
</body>
</html>