<?php
    session_start();

    require($_SERVER['DOCUMENT_ROOT'].'/Page/page.php');
    require($_SERVER['DOCUMENT_ROOT'].'/Page/functions.php');

    class index_stranka extends stranka
    {
        public $titulek = "domovská stránka";

        public function volitelne_styly()
        {
            echo "<link rel=\"stylesheet\" href=\"ucet.css\">";
        }
    }

    //kontrola přihlášení
    $username = $_POST['prihlasovaci_jmeno'];
    $password = $_POST['heslo'];
    $id = $_POST['id'];

    $result = checkLogin($id, $username, $password);
    if($result == 0)
    {
        //nepustím uživatele na domovskou stránku
        
        header("Location: ../Login/login.php");
        
    } elseif($result == 2) {
        //admin
        header("Location: ../IndexPage/admin.php");
    }
    
    $stranka = new index_stranka();

    $stranka->obsah ="
    <h1>Vítejte na domovké stránce vítáme vás</h1>";

    $stranka->zobrazeni_stranky(false);
?>


