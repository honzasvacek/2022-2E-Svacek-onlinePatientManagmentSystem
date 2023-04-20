<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chorobopis</title>
    <link rel="stylesheet" href="chorobopis.css">
</head>
<body>

<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/Page/page.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/Page/functions.php');
    require("zobrazeni_tabluky.php");

    class resultchorobopis_obsah extends zobrazeni_tabluky 
    {

    }

    $domovska_stranka = new stranka();
    $obsah = new resultchorobopis_obsah();

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

        var input = document.getElementById("id-input");
        input.value = 'KOX';

        /*var table = document.getElementById("table"); 

        var cell = document.getElementById("test");

        for(var i = 0; i < table.rows.length; i++)
        {
            table.rows[i].onclick = function()
            {
                //funkce onclick

                document.getElementById("datum-input").value = this.cells[0].innerHTML;
                document.getElementById("popisek-input").value = this.cells[1].innerHTML;

                //funkce, která najde v databázi physical_examination hodnotu

                /*const { createConnection } = require('mysql');
                const connection = createConnection({
                    host: "localhost",
                    user: "root",
                    password: "",
                    database: "svacekhealth"
                })

                connection.query(`select physical_examination from medical_records where headline =  ?`, [this.cells[1].innerHTML], (err, result) => {
                    if(err) {
                        return console.log(err);
                    }
                    var value = result;
                    return console.log(result);
                })

                document.getElementById("popisek-input").value = value;
            }
        }*/

    </script>
</html>