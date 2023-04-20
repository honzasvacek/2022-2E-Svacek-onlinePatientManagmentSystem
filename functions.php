<?php

    function getAge($id, $sex)
    {
        //uložím si dnešní datum - zvlást rok mesic a den
        $date_y = date("Y");
        $date_m = date("m");
        $date_d = date("d");

        //upravení rodného čísla
        $id = substr($id, 0, 6); //uložím si jen prvních 6 znaků rodného čísla
    
        $id_y = substr($id, 0, 2); //zde je uložené poslední dvojčíslí roku
        $id_m = substr($id, 2, -2); //zde je uložené dvojčíslí měsíce
        $id_d = substr($id, 4, 6); //zde je uložené dvojčíslí dne
        
        if($sex == "Žena")
        {
            //pohlaví - žena
            $id_m = intval($id_m) - 50; //u žen je u měsíce přičteno 50
        }
        if($id_y >= date("y"))
        {
            $id_y = "19$id_y";
        } else
          {
              $id_y = "20$id_y";
          }


        if($date_m > $id_m)
        {
            return intval($date_y - $id_y);
        }
        elseif($date_m < $id_m)
        {
            return intval($date_y - $id_y) - 1;
        } 
        elseif($date_d >= $id_d)
        {
            return intval($date_y - $id_y);
        }
        else
        {
            return intval($date_y - $id_y) - 1;
        }
    }

    function getSex($sex)
    {
        //přetypování pohlaví
        if($sex == 1)
        {
            //1 = muž
            return "Muž";
        } else
          {
              //0 = žena
              return "Žena";
          }   
    }

    function checkLogin($id, $username, $password)
    {
        if(empty($id) or empty($username) or empty($password) or !is_numeric($id))
        {
            return 0;
        }

        $db = new mysqli('localhost', 'root', '', 'svacekhealth');
        if(mysqli_connect_errno() != 0)
        {
            return 0;
        }

        //kouknu se do databáze

        //příkaz 

        $query = "SELECT UserID FROM doctors WHERE UserID = $id";

        try
        {
            //zkusím provést příkaz

            $stmt = $db->prepare($query);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($id_db);
            $stmt->fetch();
        }
        catch(PDOException $err)
        {
            //pokud rodné číslo neexistuje zachytím vyjímku

            echo $err->getMessage();
            return 0;
        }
        if(!empty($id_db))
        {
            $query = "SELECT username, password FROM doctors WHERE UserID = $id_db";

            $stmt = $db->prepare($query);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($name_db, $pass_db);
            $stmt->fetch();
        }

        if(($username == $name_db) && ($password == $pass_db))
        {
            return 1;
        }
        else {
            return 0;
        }
    }

    function patientExist($id)
    {

        if(!((strlen($id) == 10) && ((intval($id) % 11) == 0) && (is_numeric($id))))
        {
            return false;
        }

        @$db = new mysqli('localhost', 'root', '', 'svacekhealth'); 

        if(mysqli_connect_errno() != 0)
        {
            //spojení se nepodařilo, protože funkce vrátila číslo různé od nuly => číslo chyby
            echo '<p> Nepodařilo se navázat spojení s databází </p>';
            exit;
        }
        //kouknou se zda existuje

        $query = "SELECT identification_number FROM patient_account WHERE identification_number = $id";

            try
            {
                //zkusím provést příkaz

                $stmt = $db->prepare($query);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($id_from_db);
                $stmt->fetch();
            }
            catch(PDOException $err)
            {
                //pokud rodné číslo neexistuje zachytím vyjímku

                echo $err->getMessage();
                return false;
            }
            if(empty($id_from_db))
            {
                //uživatel hledá pacienta, který neexistuje

                return false;
            }

            return true;


        //kontrola jestli r.č existuje v databázi
    }

    function getName($id)
    {
        @$db = new mysqli('localhost', 'root', '', 'svacekhealth'); 

        if(mysqli_connect_errno() != 0)
        {
            //spojení se nepodařilo, protože funkce vrátila číslo různé od nuly => číslo chyby
            echo '<p> Nepodařilo se navázat spojení s databází </p>';
            exit;
        }
    
        //získáni dat z tabulky - patient_account
        $query = "SELECT surname, lastname FROM patient_account WHERE identification_number = $id";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($jmeno, $prijmeni);
        $stmt->fetch();
    
        echo $jmeno, $prijmeni;
    
        $values = array($jmeno, $prijmeni, $id);
        return $values;
    }

    function err_msg($h2, $p)
    {
        ?>
            <div class="popup-image">
                <div class="message">
                    <span>&times;</span> 
                    <h2><?php echo $h2?></h2>
                    <p id="id_exist_p"><?php echo $p ?></p>
                </div>
            </div>
            <script>
                //zobrazení popupu
                document.querySelector('.popup-image').style.display = 'block';
            </script>
        <?php
    }

    function connect_to_database()
    {
        //spojení na databázi
        @$db = new mysqli('localhost', 'root', '', 'svacekhealth');
            
        if(mysqli_connect_errno() != 0)
        {
            //spojení se nepodařilo, protože funkce vrátila číslo různé od nuly => číslo chyby
            return 0;
        }

        return $db;
    }

    function get_name_from_database($db, $id)
    {
        $jmeno = "";
        $prijmeni = "";
        //získáni dat z tabulky - patient_account
        $query = "SELECT surname, lastname FROM patient_account WHERE identification_number = $id";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($jmeno, $prijmeni);
        $stmt->fetch();

        $names = array($jmeno, $prijmeni);
        return $names;
    }

    function format_id($id)
    {
        $first6 = substr($id, 0, 6);
        $last4 = substr($id, 6); 
        $formated_id = "$first6/$last4";

        return $formated_id;
    }

?>