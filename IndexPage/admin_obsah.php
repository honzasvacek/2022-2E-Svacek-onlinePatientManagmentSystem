<?php
class admin
{
    public function obsah()
    {
        ?>

            <div class="container">
                <div class="form-container">
                    <form action="admin_send.php" method="post">
                        <div class="text">
                            <h2>Založení nového profilu</h2>
                        </div>
                        <div class="username">
                            <p>Jméno: </p>
                            <input type="text" placeholder="Jméno" name="username">
                        </div>
                        <div class="password">
                            <p>Heslo: </p>
                            <input type="password" placeholder="Heslo" name="password">
                        </div>
                        <div class="password">
                            <p>Heslo znovu: </p>
                            <input type="password" placeholder="Heslo znovu" name="password_again">
                        </div>
                        <div class="button-container">
                            <button type="submit">Uložit</button>
                        </div>
                    </form>
                </div>
            </div>

        <?php
    }
}
?>