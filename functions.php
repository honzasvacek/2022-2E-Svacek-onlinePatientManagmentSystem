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

?>