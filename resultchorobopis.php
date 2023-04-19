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
    require("page.php");
    require("chorobopis_obsah.php");
    require("functions.php");

    class resultchorobopis_obsah extends chorobopis_obsah
    {
        public function zobrazeni_tabulky()
        {
            //změním zděděnou funkci, aby vypisovala obsah z databáze

            //hledané r.č
            $id = trim($_POST['rodne_cislo']);

            //data z databáze
            @$db = new mysqli('localhost', 'root', '', 'svacekhealth'); 

            if(mysqli_connect_errno() != 0)
            {
                //spojení se nepodařilo, protože funkce vrátila číslo různé od nuly => číslo chyby
                echo '<p> Nepodařilo se navázat spojení s databází </p>';
                exit;
            }

            //kontrola jestli r.č existuje v databázi
            $i = 0;

            if(patientExist($id))
            {
                $query = "SELECT date, physical_examination, headline FROM medical_records WHERE identification_number = $id";
                $stmt = $db->prepare($query);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($datum, $popis, $titulek);

                while($stmt->fetch())
                {
                    if($i % 2 == 0)
                    {
                        echo "<tr style=\"background-color: white;\">
                                    <td>$datum</td>
                                    <td>$titulek</td>
                                </tr>";
                    } else {
                        echo "<tr id=\"test\" style=\"background-color:rgb(241, 241, 241);\">
                                <td>$datum</td>
                                <td>$titulek</td>
                            </tr>";
                    }

                    $i++;
                }

            }

            if($i < 11)
            {
                //chci doplnit prázdné řádky, aby to vypadalo pěkně

                $radky = 11 - $i;

                for($j = 0; $j < $radky; $j++)
                {
                    if($i % 2 == 0) {
                        if($j % 2 == 0)
                        {
                            echo "<tr id=\"test\" style=\"background-color: white;\">
                                        <td></td>
                                        <td></td>
                                    </tr>";
                        } else {
                            echo "<tr id=\"test\" style=\"background-color:rgb(241, 241, 241);\">
                                    <td></td>
                                    <td></td>
                                </tr>";
                        }
                    } else {
                        if($j % 2 == 0)
                        {
                            echo "<tr id=\"test\" style=\"background-color: rgb(241, 241, 241);\">
                                        <td></td>
                                        <td></td>
                                    </tr>";
                        } else {
                            echo "<tr id=\"test\" style=\"background-color: white\">
                                    <td></td>
                                    <td></td>
                                </tr>";
                        }
                    }
                    
                }
            }

            $db = NULL;

            //nastavení jedotlivých řádku tak, aby na ně šlo kliknout

            ?>

            <?php

        }

        public function zobrazeni_detailu()
        {

            ?>

                <div class="content" id="content">
                    <?php
                    $datum = $_COOKIE['datum'];

                    $popisek = $_COOKIE['popisek'];

                    ?>
                    <div>
                        <input type="text" name="datum-input" id="datum-input" value="" size="25">
                    </div>
                    <div>
                        <input type="text" name="popisek-input" id="popisek-input" value="" size="25">
                    </div>
                </div>

            <?php


        }
    }

    $domovska_stranka = new stranka();
    $obsah = new resultchorobopis_obsah();

    if(patientExist(trim($_POST['rodne_cislo'])))
    {
        //vrátilo true => existuje
        $id = trim($_POST['rodne_cislo']);
        $values = getName($id);
        $domovska_stranka->obsah =$obsah->zobrazeni_obsahu("Pacient $values[0] $values[1] rč. $values[2]");
    } else {
        $domovska_stranka->obsah =$obsah->zobrazeni_obsahu("Pacient neexsituje");
    }

    $domovska_stranka->zobrazeni_stranky();
?>

</body>

<script>
        /*var table = document.getElementById("table"); 

        var cell = document.getElementById("test");

        for(var i = 0; i < table.rows.length; i++)
        {
            table.rows[i].onclick = function()
            {
                //funkce onclick

                document.getElementById("datum-input").value = this.cells[0].innerHTML;
                //document.getElementById("popisek-input").value = this.cells[1].innerHTML;

                //funkce, která najde v databázi physical_examination hodnotu

                const { createConnection } = require('mysql');
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