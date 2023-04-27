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
            $query = "SELECT record_id FROM patient_id WHERE identification_number = $id";
            $stmt = $db->prepare($query);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($record_id);
            $stmt->fetch();

            $query = "SELECT examination, date FROM medical_record WHERE record_id = $record_id";
            $stmt = $db->prepare($query);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($datum, $vysetreni);
        
            while($stmt->fetch())
            {
                if($i % 2 == 0)
                {
                    echo "<tr style=\"background-color: white;\">
                                <td>$vysetreni</td>
                                <td>$datum</td>
                            </tr>";
                } else {
                    echo "<tr id=\"test\" style=\"background-color:rgb(241, 241, 241);\">
                                <td>$vysetreni</td>
                                <td>$datum</td>
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