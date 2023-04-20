<?php

class chorobopis_obsah
{
    
    public function zobrazeni_obsahu($headline, $id, $type)
    {
        $this->ziskani_dat();
        ?>
        
        <div class="container">
            <div class="headline"><h1><?php echo $headline; ?></h1></div>
            <div class="content_container">
                <div class="record_table">
                    <table id="table">
                        <tr>
                            <th>Datum</th>
                            <th>Denní záznam</th>
                        </tr>
                    <?php $this->zobrazeni_tabulky($type); ?>
                    </table>
                </div>
                <div class="record_detail">
                    <?php $this->zobrazeni_detailu($id) ?>
                </div>
            </div>
        </div>
        
        <?php
    }

    public function ziskani_dat()
    {

    }

    public function zobrazeni_tabulky($type)
    {

        for($i = 0; $i < 11; $i++)
        {
            if($i % 2 == 0)
            {
                ?>
                    <tr style="background-color: white;">
                        <td ></td>
                        <td ></td>
                    </tr>
                <?php
            } else {
                ?>
                    <tr style="background-color: rgb(241, 241, 241);">
                        <td></td>
                        <td></td>
                    </tr>
                <?php
            }
        }
    }

    public function zobrazeni_detailu($id)
    {?>
        <div class="date-div">
            <h2>
                <?php
                     $date_y = date("Y");
                     $date_m = date("m");
                     $date_d = date("d");
                    echo "Dnešní datum: $date_d-$date_m-$date_y"             
                ?>
            </h2>
        </div>
        <form action="chorobopis_addrecord.php" method="POST">
            <div class="input-div" id="content">
                <p class="id_p"> 
                    Rodné číslo
                </p>
                <div>
                    <?php echo "<input type=\"text\" name=\"id-input\" id=\"id-input\" value=\"$id\" size=\"40\">"; ?>
                </div>
                <p>
                    Denní záznam
                </p>
                <div>
                    <?php echo "<input class=\"zaznam\" type=\"text\" name=\"examination-input\" id=\"examination-input\" value=\"\" size=\"40\">";?>
                </div>
            </div>
            <div class="add_record_container">
            
                <button>Přidat záznam</button>
            
            </div>
        </form>
    <?php
    }

}

?>