<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chorobopis-data</title>
    <link rel="stylesheet" href="chorobopis.css">
</head>
<body>

<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/Page/page.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/Page/functions.php');
    require("zobrazeni_tabluky.php");

    class chorobopis_addrecord extends zobrazeni_tabluky
    {
        public function ziskani_dat()
        {
            //získání rodného číslo a denního záznamu
            @$id = $_POST['id-input'];
            @$examination = $_POST['examination-input'];

            if(empty($id) OR empty($examination))
            {
                //uživatel nevyplnil některé údaje
                err_msg("Odeslání neúspěšné","Nevyplnili jste všechny údaje");
                return 0;
            }

            if(patientExist($id) == false)
            {
                err_msg("Odeslání neúspěšné","Pacient s vyplněným rodným číslem neexistuje");
                return 0;
            }

            $db = connect_to_database();

            //získání dat z databáze

            $query = "INSERT INTO medical_records (identification_number, physical_examination) VALUES(?, ?)";
            $stmt = $db->prepare($query);
            $stmt->bind_param('is', $id, $examination);
            $stmt->execute();

        }
    }

    $domovska_stranka = new stranka();
    $obsah = new chorobopis_addrecord();

    @$id = $_POST['id-input'];

    $db = connect_to_database();
    $names = get_name_from_database($db, $id);

    $id = format_id($id);

    $domovska_stranka->zobrazeni_obsahu = $obsah->zobrazeni_obsahu("$names[0] $names[1] rč.$id",$_POST['id-input'], 2);
    $domovska_stranka->zobrazeni_stranky();
?>

</body>
<script>
    //nastavím spanu, což je křížek, akci onclick
    document.querySelector('.popup-image span').onclick = () =>
        {
            //když se spustí onclick schovám popup
            document.querySelector('.popup-image').style.display = 'none';
        }
</script>
</head>