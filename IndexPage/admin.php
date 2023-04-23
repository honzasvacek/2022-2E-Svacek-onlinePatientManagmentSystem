<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
<?php
    require($_SERVER['DOCUMENT_ROOT'].'/Page/page.php');
    require('admin_obsah.php');

    $domovska_stranka = new stranka();
    $obsah = new admin();

    $domovska_stranka->obsah = $obsah->obsah();

    $domovska_stranka->zobrazeni_stranky(false);
?>
    </body>
</html>

