<?php

require("chorobopis_obsah.php");

class zobrazeni_tabluky extends chorobopis_obsah
{
    public function zobrazeni_tabulky($type)
    {
        if($type == 1)
        {
            //rodné číslo získám z vyhledávacího pole

            $id = $_POST['rodne_cislo'];
        } 
        else if($type == 2)
        {
            //rodné číslo získám z input pole

            $id = $_POST['id-input'];
        } 
  
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
            $query = "SELECT date, physical_examination FROM medical_records WHERE identification_number = $id";

            try
            {
                $stmt = $db->prepare($query);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($datum, $vysetreni);
            }
            catch(PDOException $err)
            {
                return 0;
            }
    
            while($stmt->fetch())
            {
                if($i % 2 == 0)
                {
                    echo "<tr style=\"background-color: white;\">
                                <td>$datum</td>
                                <td>$vysetreni</td>
                            </tr>";
                } else {
                    echo "<tr id=\"test\" style=\"background-color:rgb(241, 241, 241);\">
                            <td>$datum</td>
                            <td>$vysetreni</td>
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

    }

}

?>