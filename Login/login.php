<?php

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    ?>
        <div class="popup-image">
<div class="message">
    <span>&times;</span> <!-- html entita, která vytvoří symbol křížku -->
    <h2>Přihlášení - Neúspěšné</h2>
    <p style="margin-bottom: 0;">
        *Zkontrolujte prosím znovu, zda jste zadali přihlašovací správně. 
    </p>
</div>
</div>
<script>document.querySelector('.popup-image').style.display = 'block';</script>
    <?php
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>login page</title>
</head>
<body>
    <div class="container">
        <div class="left_container">
            <div class="up_left_container">

            </div>
            <form class="tableOfOrders" action="../IndexPage/index.php" method="POST">
            <p class="svacekhealth_text">SVACEK HEALTH - Přihlášení</p>
                <div class="id_container">
                    <p class="username">ID</p>
                    <input class="loginarray" type="text" name="id" size="25">
                 </div>
                 <div class="username_container">
                    <p class="username">Přihlašovací jméno</p>
                    <input class="loginarray" type="text" name="prihlasovaci_jmeno" size="25">
                 </div>
                 <div class="password_container">
                    <p class="logininfotext">Heslo</p>
                    <input class="loginarray" type="password" name="heslo" size="25">
                 </div>
                 <div class="loginbutton_container">
                    <input class="loginbutton" type="submit" value="Přihlásit se">
                 </div>
            </form>
            <div class="down_left_container">

            </div>
        </div>
        <div class="right_container">
            <img class="logo" src="../Pictures/Header-buttons/SvacekHealthLogo.PNG">
        </div>
    </div>
</body>
    <script>
            //nastavím spanu, což je křížek, akci onclick
            document.querySelector('.popup-image span').onclick = () =>
            {
                //když se spustí onclick schovám popup
                document.querySelector('.popup-image').style.display = 'none';
            }
    </script>
</html>