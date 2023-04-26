<?php
    require($_SERVER['DOCUMENT_ROOT'].'/Page/page.php');
    require($_SERVER['DOCUMENT_ROOT'].'/Page/functions.php');
    require('admin_obsah.php');

    class admin_send_stranka extends stranka
    {
        public $titel = "Admin - Uložení účtu";

        public function volitelne_styly()
        {
            echo "<link rel=\"stylesheet\" href=\"admin.css\">";
            echo "<link rel=\"stylesheet\" href=\"../Page/popup.css\">";
        }
    }

    function admin_send_obsah()
    {
        $h2 = "Vytvoření účtu - Neúspěšné";
        //vyřízení formuláře
        @$username = $_POST['username'];
        @$password = $_POST['password'];
        @$password_again = $_POST['password_again'];

        if(empty($username) OR empty($password) OR empty($password_again))
        {
            err_msg($h2, "Nevyplnili jste všechny údaje");
            return 0;
        }

        if($password != $password_again)
        {
            err_msg($h2, "Hesla se neshodují");
        }

        if(is_numeric($username) OR strlen($password) < 7)
        {
            err_msg($h2, "Jméno nesmí být číselné a heslo musí mít nejméně 8 znaků");
            return 0;
        }
        //zahašování hesla
        $password = password_hash($password, PASSWORD_DEFAULT);

        //kontrola proběhla => dám data do databáze
        $db = connect_to_database();

        $query = "INSERT INTO doctors (Username, Password) VALUES(?,?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('ss', $username, $password);
        $stmt->execute();

        $db = NULL;
    }

    admin_send_obsah();

    $stranka = new admin_send_stranka();
    $obsah = new admin;

    $stranka->obsah = $obsah->obsah();
    $stranka->zobrazeni_stranky(false);

?>
