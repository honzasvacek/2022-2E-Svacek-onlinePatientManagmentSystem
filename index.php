<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Domovská stránka</title>
    <link rel="stylesheet" href="ucet.css">
</head>
<body>
<?php
    require("page.php");
    require("functions.php");

    //kontrola přihlášení
    $username = $_POST['prihlasovaci_jmeno'];
    $password = $_POST['heslo'];
    $id = $_POST['id'];
   

    if(checkLogin($id, $username, $password) == 0)
    {
        //nepustím uživatele na domovskou stránku

        header("Location: login.php");
    }
    
    $domovska_stranka = new stranka();

    $domovska_stranka->obsah ="
    <h1>Vítejte na domovké stránce vítáme vás</h1>";

    $domovska_stranka->zobrazeni_stranky();
?>
    </body>
</html>

