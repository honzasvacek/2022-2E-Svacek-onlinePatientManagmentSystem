<?php
    class seznam_tabulka
    {
        public function zobrazeni_obsahu($jeHledano)
        {
            $this->zobrazeni_tabulky($jeHledano);
        }

        public function je_v_databazi($x)
        {
            //musím zjistit zda je v databázi
            return true;
        }

        public function zobrazeni_tabulky($jeHledano)
        {
            //vytvářím připojení k databázi
            @$db = new mysqli('localhost', 'root', '', 'svacekhealth'); 

            if(mysqli_connect_errno() != 0)
            {
                //spojení se nepodařilo, protože funkce vrátila číslo různé od nuly => číslo chyby
                echo '<p> Nepodařilo se navázat spojení s databází </p>';
                exit;
            }

            //získání dat z tabulky
            $query = "SELECT surname, lastname, identification_number FROM patient_account ORDER BY lastname"; //uložení příkazu do query
            $stmt = $db->prepare($query); //připravím příkaz na dotaz databázi 
            $stmt->execute(); //provedu příkaz
            $stmt->store_result(); //uložím výsledek do mezipaměti
            $stmt->bind_result($jmeno, $prijmeni, $rodnecislo); //vázané proměnné k jednotlivým sloupcům

            //výpis výsledků
            if($_SERVER['REQUEST_METHOD'] == "POST")
            {
                //uložím si si hledané rodné číslo
                $rodnecislo_post = trim($_POST['rodne_cislo']);
            }
            
            //pokud je v databázi provedu vypsání tabulky

            //začátek tabulky
            echo "<div class=\"container\">";
            echo "<div class=\"tableOuterBorder\">";
            echo "<div class=\"tableContainer\">";
            echo "<table>
                    <tr>
                        <th class=\"sljm\">Jméno</th>
                        <th class=\"sljm\">Příjmení</th>
                        <th class=\"sljm\">Rodné číslo</th>
                    </tr>";

            //proměnná $i poslouží k tomu, aby se lišila barva mezi lichými s sudými řádky
            $i = 1;

            while($stmt->fetch())
            {
                //dokud je co číst budu vypisovat řádky z daty

                //x
                if($jeHledano)
                {
                    //uživatel zadal do pole rodné číslo

                    if($rodnecislo_post == $rodnecislo)
                    {
                        //rodné číslo pacienta JE současně hledané rodné číslo uživatelem => změním barvu jeho pozadí

                        echo "<tr style=\"background-color: aquamarine;\">
                                <td>$jmeno</td>
                                <td>$prijmeni</td>
                                <td>$rodnecislo</td>
                             </tr>";
                    }

                    
                    //rodné číslo pacienta NENÍ současně hledané rodné číslo uživatelem => zvypisuji obsah tabulky

                    elseif($i%2 == 0)
                    {
                        //sudý řádek bude mít bílou barvu

                        echo "<tr style=\"background-color:white;\">
                                <td>$jmeno</td>
                                <td>$prijmeni</td>
                                <td>$rodnecislo</td>
                            </tr>";
                    }
                    else
                    {
                        //lichý řádek bude mít šedivou barvu

                        echo "<tr style=\"background-color:rgb(241, 241, 241);\">
                                <td>$jmeno</td>
                                <td>$prijmeni</td>
                                <td>$rodnecislo</td>
                            </tr>";
                    }
                    $i++;
                }
                else
                {
                    //rodné číslo pacienta NENÍ současně hledané rodné číslo uživatelem => zvypisuji obsah tabulky

                    if($i%2 == 0)
                    {
                        //sudý řádek bude mít bílou barvu

                        echo "<tr style=\"background-color:white;\">
                                <td>$jmeno</td>
                                <td>$prijmeni</td>
                                <td>$rodnecislo</td>
                            </tr>";
                    }
                    else
                    {
                        //lichý řádek bude mít šedivou barvu

                        echo "<tr style=\"background-color:rgb(241, 241, 241);\">
                                <td>$jmeno</td>
                                <td>$prijmeni</td>
                                <td>$rodnecislo</td>
                            </tr>";
                    }
                    $i++;
                }
                

            }
            //konec tabulky

            echo "</table>";
            echo "</div>";
            echo "</div>";
            
        
            if($jeHledano && $this->je_v_databazi($rodnecislo_post) == false)
            {
                //pokud není v databázi vypíšu zprávu, že pacient není v databázi

                ?>
                    <div class="popup-image">
                        <div class="message">
                            <span>&times;</span> <!-- html entita, která vytvoří symbol křížku -->
                            <h2>Hledání - Neúspěšné</h2>
                            <p>
                                *Pacient není evidován v databázi
                            </p>
                        </div>
                    </div>

                    <script>document.querySelector('.popup-image').style.display = 'block';</script>

                <?php

            }
        

        }

    }
?>


<?php /*
    class eznam_tabulka
    {

        public function zobrazeni_tabulky_post()
        {
            @$db = new mysqli('localhost', 'root', '', 'svacekhealth'); //vytvářím připojení k databázi
            if(mysqli_connect_errno() != 0)
            {
                //spojení se nepodařilo, protože funkce vrátila číslo různé od nuly => číslo chyby
                echo '<p> Nepodařilo se navázat spojení s databází </p>';
                exit;
            }
            //získání dat z tabulky
            $query = "SELECT surname, lastname, identification_number FROM patient_account"; //uložení příkazu do query
            $stmt = $db->prepare($query); //připravím příkaz na dotaz databázi 
            $stmt->execute(); //provedu příkaz
            $stmt->store_result(); //uložím výsledek do mezipaměti
            $stmt->bind_result($jmeno, $prijmeni, $rodnecislo); //vázané proměnné k jednotlivým sloupcům
            //výpis výsledků
            if($_SERVER['REQUEST_METHOD'] == "POST")
            {
                $rodnecislo_post = trim($_POST['rodne_cislo']);
                if($this->je_v_databazi($rodnecislo_post) == true)
                {
                    echo "<div class=\"container\">";
                    echo "<div class=\"tableOuterBorder\">";
                    echo "<div class=\"tableContainer\">";
                    echo "<table>
                            <tr>
                                <th class=\"sljm\">Jméno</th>
                                <th class=\"sljm\">Příjmení</th>
                                <th class=\"sljm\">Rodné číslo</th>
                            </tr>";
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
                                 </tr>";
                        }else
                        {
                            if($i%2 == 0)
                            {
                                echo "<tr style=\"background-color:white;\">
                                        <td>$jmeno</td>
                                        <td>$prijmeni</td>
                                        <td>$rodnecislo</td>
                                    </tr>";
                            }else
                            {
                                echo "<tr style=\"background-color:rgb(241, 241, 241);\">
                                        <td>$jmeno</td>
                                        <td>$prijmeni</td>
                                        <td>$rodnecislo</td>
                                    </tr>";
                            }
                            $i++;
                        }
                        
                    }
                }
                else
                {
                    ?>
                        <div class="popup-image">
                            <div class="message">
                                <span>&times;</span> <!-- html entita, která vytvoří symbol křížku -->
                                <h2>Hledání - Neúspěšné</h2>
                                <p>
                                    *Pacient není evidován v databázi
                                </p>
                            </div>
                        </div>
                        <script>document.querySelector('.popup-image').style.display = 'block';</script>
                    <?php
                } 
            
        }

        

    }*/
?>