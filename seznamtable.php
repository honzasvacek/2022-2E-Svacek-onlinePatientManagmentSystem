<?php
    class seznam_tabulka
    {
        public function zobrazeni_tabulky()
        {
            @$db = new mysqli('localhost', 'root', '', 'svacekhealth'); //vytvářím připojení k databázi
                    if(mysqli_connect_errno() != 0)
                    {
                    //spojení se nepodařilo, protože funkce vrátila číslo různé od nuly => číslo chyby
                    echo '<p> Nepodařilo se navázat spojení s databází </p>';
                    exit;
                    }
                    //získání dat z tabulky
                    $query = "SELECT jmeno, prijmeni, rodnecislo FROM ucet"; //uložení příkazu do query
                    $stmt = $db->prepare($query); //připravím příkaz na dotaz databázi 
                    $stmt->execute(); //provedu příkaz
                    $stmt->store_result(); //uložím výsledek do mezipaměti
                    $stmt->bind_result($jmeno, $prijmeni, $rodnecislo); //vázané proměnné k jednotlivým sloupcům
                    //výpis výsledků
                    if($_SERVER['REQUEST_METHOD'] == "POST")
                    {
                        $rodnecislo_post = trim($_POST['rodne_cislo']);
                        if((!empty($rodnecislo_post)) && (strlen($rodnecislo_post) == 10) && ((intval($rodnecislo_post) % 11) == 0))
                        {
                            echo "<div class=\"container\">";
                            echo "<div class=\"tableOuterBorder\">";
                            echo "<div class=\"tableContainer\">";
                            echo "<table>
                                    <tr>
                                        <th class=\"sljm\">Jméno</th>
                                        <th class=\"sljm\">Příjmení</th>
                                        <th class=\"sljm\">Rodné číslo</th>";
                            $i = 1;
                            while($stmt->fetch())
                            {
                                //dokud je co číst, čtu řádek - hodnota sloupce se vždy uloží do příslušné proměnné
                                if($rodnecislo_post == $rodnecislo)
                                {
                                    echo "<tr style=\"background-color: aquamarine;\">
                                        <td>$jmeno</td>
                                        <td>$prijmeni</td>
                                        <td>$rodnecislo</td>
                                    <tr>";
                                }else
                                {
                                    if($i%2 == 0)
                                    {
                                        echo "<tr style=\"background-color:white;\">
                                                <td>$jmeno</td>
                                                <td>$prijmeni</td>
                                                <td>$rodnecislo</td>
                                            <tr>";
                                    }else
                                    {
                                        echo "<tr style=\"background-color:rgb(241, 241, 241);\">
                                                <td>$jmeno</td>
                                                <td>$prijmeni</td>
                                                <td>$rodnecislo</td>
                                            <tr>";
                                    }
                                    $i++;
                                }
                                
                            }
                        }else
                         {
                            echo "<div class=\"formContainer\">";
                            echo "<form class=\"PatientNotInDB\" action=\"ucet.php\" method=\"POST\">";
                            echo "<div class=\"pContainer\">";
                            echo "<p>Tento pacient není v databázi, v případě, že chcete pacienta přidat stiskněte tlačítko  <i>Přidat pacienta</i></p>";
                            echo "</div>";
                            echo "<div class=\"btnContainer\">";
                            echo "<input class=\"createAccBtn\" type=\"submit\" value=\"Přidat pacienta\"/>";
                            echo "</div>";
                            echo "</div>";
                            
                         } 
                    }else
                     {
                        echo "<div class=\"container\">";
                            echo "<div class=\"tableOuterBorder\">";
                            echo "<div class=\"tableContainer\">";
                            echo "<table>
                                    <tr>
                                        <th class=\"sljm\">Jméno</th>
                                        <th class=\"sljm\">Příjmení</th>
                                        <th class=\"sljm\">Rodné číslo</th>";
                        $i = 1;
                        while($stmt->fetch())
                        {
                            //dokud je co číst, čtu řádek - hodnota sloupce se vždy uloží do příslušné proměnné
                            if($i%2 == 0)
                            {
                                echo "<tr style=\"background-color:white;\">
                                        <td>$jmeno</td>
                                        <td>$prijmeni</td>
                                        <td>$rodnecislo</td>
                                     <tr>";
                            }else
                             {
                                 echo "<tr style=\"background-color:rgb(241, 241, 241);\">
                                         <td>$jmeno</td>
                                         <td>$prijmeni</td>
                                         <td>$rodnecislo</td>
                                      <tr>";
                             }
                            $i++;
                        }
                     }
                    echo "</tr>
                        </table>";
                    echo "</div>";
                    echo "</div>";
        }
    }
?>