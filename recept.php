<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recepty</title>
    <link rel="stylesheet" href="recept.css">
</head>
<body>
<?php
    class recept
    {
        public function zobrazeni_obsahu_receptu()
        {
            ?>
            <div class="outer_container">
                <div class="container">
                    <div class="image-container">
                        <div class="image"><p>Recept ICP - lékařský předpis</p><img src="Recepty/recept_leky.jpg" alt=""></div>
                        <div class="image"><p>Poukaz na vyšetření/ oštření</p><img src="Recepty/Poukaz_vysos.PNG" alt=""></div>
                        <div class="image"><p>Průkazka o zdravotní péči</p><img src="Recepty/prukazka_zdravotni_pece.jpg" alt=""></div>
                        <div class="image"><p>Objednávka léku</p><img src="Recepty/objednavka_leku.jpg" alt=""></div>
                        <div class="image"><p>Zdravotní záznam - stromatologie</p><img src="Recepty/stromatologie.jpg" alt=""></div>
                        <div class="image"><p>Vyučtování výkonů v ambulantní péči</p><img src="Recepty/vyuctovani_ambpece.PNG" alt=""></div>
                    </div>

                    <div class="popup-image">
                        <span>&times;</span> <!-- html entita, která vytvoří symbol křížku -->
                        <img src="Recepty/recept_leky.jpg" alt="">
                        <button id="btn-tisk" class="btn-tisk" >Tisk</button>
                    </div>
                </div>
            </div>

            <script>
                document.querySelectorAll('.image-container img').forEach(image =>
                {
                    image.onclick = () =>
                    {
                        document.querySelector('.popup-image').style.display = 'block';
                        document.querySelector('.popup-image img').src = image.getAttribute('src');
                    }
                });

                //nastavím spanu, což je křížek, akci on
                document.querySelector('.popup-image span').onclick = () =>
                {
                    document.querySelector('.popup-image').style.display = 'none';
                }

                //tlačítko na tisk
                const btn_tisk = document.getElementById('btn-tisk'); //uložím si tlačítko do proměnné

                //nastavím co se stane když na tlačítko někdo klikne
                btn_tisk.addEventListener('click', function() 
                {
                    print(); //vytisknu obsah
                });

            </script>

            <?php
        }
    }

    require("page.php");

    $domovska_stranka = new stranka();
    $obsah = new recept;

    $domovska_stranka->obsah = $obsah->zobrazeni_obsahu_receptu();
    $domovska_stranka->zobrazeni_stranky();
?>
</body>