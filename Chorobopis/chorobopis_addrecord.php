<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chorobopis-data</title>
    <link rel="stylesheet" href="chorobopis.css">
    <link rel="stylesheet" href="../Page/popup.css">
</head>
<body>

<?php
    require($_SERVER['DOCUMENT_ROOT'].'/Page/page.php');
    require($_SERVER['DOCUMENT_ROOT'].'/Page/functions.php');
    require("zobrazeni_tabluky.php");

    class chorobopis_addrecord extends zobrazeni_tabluky
    {
        public function ziskani_dat()
        {
            chorobopis_send();
        }
    }

    $domovska_stranka = new stranka();
    $obsah = new chorobopis_addrecord();

    if(patientExist(@$id = $_POST['id-input']))
    {
        $db = connect_to_database();
        $names = get_name_from_database($db, $id);
        $id = format_id($id);
    
        $domovska_stranka->zobrazeni_obsahu = $obsah->zobrazeni_obsahu("$names[0] $names[1] rč.$id",$_POST['id-input'], 2);
    } else {
        $domovska_stranka->obsah =$obsah->zobrazeni_obsahu("Pacient neexsituje", "", 2);
    }

    $domovska_stranka->zobrazeni_stranky(true);
?>

</body>
</head>