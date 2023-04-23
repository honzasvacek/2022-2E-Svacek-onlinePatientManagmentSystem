<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seznam</title>
    <link rel="stylesheet" href="seznam.css">
    <link rel="stylesheet" href="../Page/popup.css">
</head>
<body>
<?php   
    require($_SERVER['DOCUMENT_ROOT'].'/Page/page.php');
    require($_SERVER['DOCUMENT_ROOT'].'/Page/functions.php');
    require("seznamtable.php");

    $stranka = new stranka();
    $seznam_pacientu = new seznam_tabulka(); 

    $jeHledano = true;

     //uložím si si hledané rodné číslo
     $rodnecislo_post = trim($_POST['rodne_cislo']);
     //výpis výsledků
     if($jeHledano == true)
     {
        if(patientExist($rodnecislo_post))
        {
            err_msg("Hledání - Úspěšné", "Pacient existuje");
        } else {
            err_msg("Hledání - Neúspěšné", "Pacient neexistuje");
        }
     }

    $stranka->zobrazeni_stranky(true);
    $stranka->obsah = $seznam_pacientu->zobrazeni_obsahu($jeHledano);
?>
</body>
</html>


