<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Send request</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="../Page/popup.css">
</head>
<body>
<?php
    require($_SERVER['DOCUMENT_ROOT'].'/Page/page.php');
    require($_SERVER['DOCUMENT_ROOT'].'/Page/functions.php');
    require('admin_obsah.php');

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

    $stranka = new stranka();
    $obsah = new admin;

    $stranka->obsah = $obsah->obsah();
    $stranka->zobrazeni_stranky(false);
?>
</body>
</html>