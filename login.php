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
            <form class="tableOfOrders" action="index.php" method="POST">
                 <div class="username_container">
                    <p class="svacekhealth_text">SVACEK HEALTH - Přihlášení</p>
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
            <img class="logo" src="Pictures/SvacekHealthLogo.PNG">
        </div>
    </div>
</body>
</html>