<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chorobopis</title>
    <link rel="stylesheet" href="chorobopis.css">
    <link rel="stylesheet" href="../Page/popup.css">
</head>
<body>

<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/Page/page.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/Page/functions.php');
    require("zobrazeni_tabluky.php");

    class resultchorobopis extends zobrazeni_tabluky
    {
        public function ziskani_dat()
        {
            if(patientExist($_POST['rodne_cislo']) == false)
            {
                err_msg("Hledání - Neúspěšné", "Pacient není v databázi");
                return 0;
            }
        }
    }

    $domovska_stranka = new stranka();
    $obsah = new resultchorobopis();

    if(patientExist(trim($_POST['rodne_cislo'])))
    {
        //vrátilo true => existuje
        $id = trim($_POST['rodne_cislo']);
        $values = getName($id);

        $first6 = substr($values[2], 0, 6);
        $last4 = substr($values[2], 6); 
        $formated_id = "$first6/$last4";
        $domovska_stranka->obsah =$obsah->zobrazeni_obsahu("Pacient $values[0] $values[1] rč. $formated_id", $values[2], 1);
    } else {
        $domovska_stranka->obsah =$obsah->zobrazeni_obsahu("Pacient neexsituje", "", 1);
    }

    $domovska_stranka->zobrazeni_stranky(true);
?>

</body>
</html>