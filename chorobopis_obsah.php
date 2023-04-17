<?php

class chorobopis_obsah
{
    
    public function zobrazeni_obsahu($headline)
    {
        ?>
        
        <div class="container">
            <div class="headline"><h1><?php echo $headline; ?></h1></div>
            <div class="content_container">
                <div class="record_table">
                    <?php $this->zobrazeni_tabulky(); ?>
                </div>
                <div class="record_detail"></div>
            </div>
            <div class="add_record_container">
                <form action="chorobopis_addrecord.php" method="POST">
                    <button>Přidat záznam</button>
                </form>
            </div>
        </div>
        
        <?php
    }

    public function zobrazeni_tabulky()
    {
        ?>
        <table>
            <tr>
                <th>Datum</th>
                <th>Vyštření</th>
            </tr>
            <?php
                for($i = 0; $i < 30; $i++)
                {
                    if($i % 2 == 0)
                    {
                        ?>
                            <tr style="background-color: white;">
                                <td >Datum</td>
                                <td >Vyštření</td>
                            </tr>
                        <?php
                    } else {
                        ?>
                            <tr style="background-color: rgb(241, 241, 241);">
                                <td>Datum</td>
                                <td>Vyštření</td>
                            </tr>
                        <?php
                    }
                }
            ?>
        </table>
        <?php
    }

}

?>