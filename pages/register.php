<?php
session_start();
include_once ($webRoot = str_replace($_SERVER['PHP_SELF'], "", $_SERVER['SCRIPT_FILENAME'])) . "/php/functions.php";
if ($_SESSION['user']['id'] != "") { //se è già loggato
    setHeaders(["redirect" => "/"]);
} else {

    //HEADER 
    setHeaders([
        "meta-title" => "Registrazione",
    ]);

    /* TRACCIA SOLO SE E' UN LINK SPA ALTRIMENTI HA GIA' TRACCIATO LA INDEX.PHP, SE E' ARRIVATO FIN QUI VUOL DIRE CHE E' SAFE*/
    if ($_POST['spa']) security_uri($_POST['urlrewrite']);
    /* TRACCIA SOLO SE E' UN LINK SPA ALTRIMENTI HA GIA' TRACCIATO LA INDEX.PHP, SE E' ARRIVATO FIN QUI VUOL DIRE CHE E' SAFE*/
?>
    <div class="blur-backdrop overflow-hidden wow fadeIn">
        <div class="container py-4 px-3 px-lg-0">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-5 text-center">
                    <?php
                    if (isset($_GET['verify-sent'])) {
                    ?>
                        <h2 class="fw-semibold mb-4">Verifica email</h2>
                        <div class="bg-success bg-opacity-25 alert mb-3 rounded-0" role="alert">
                            <?php
                            if ($_GET['verify-sent'] != "")
                                echo "Ti abbiamo inviato un email di verifica all'indirizzo da te indicato.";
                            else
                                echo "Abbiamo inviato nuovamente un email di verifica all'indirizzo da te indicato.";
                            ?>
                        </div>
                        <?php if ($_GET['verify-sent'] != "") {
                        ?>
                            <p>Se non l'hai ricevuta <a href="php/confirm_email.php?resend=<?php echo $_GET['verify-sent']; ?>">clicca qui</a> per inviarla nuovamente.</p>
                        <?php
                        } else {
                        ?>
                            <p>Se non hai ricevuto alcuna email controlla la casella spam o contatta l'assistenza.</p>
                        <?php
                        } ?>

                        <?php
                    } else {
                        foreach ($_SESSION['alert'] as $key => $value) {
                        ?>
                            <div class="alert alert-<?php echo $value['style']; ?> mb-4" role="alert"><?php echo $value['message']; ?></div>
                        <?php
                        }
                        unset($_SESSION['alert']);
                        ?>
                        <h2 class="fw-semibold mb-4">Nuovo utente</h2>
                        <form action="php/register.php" method="post" class="captcha">
                            <div class="form-floating mb-3">
                                <input name="email" type="email" class="form-control border-top-0 border-start-0 border-end-0 border-2 border-black  border-bottom-3 rounded-0 bg-transparent no-outline" placeholder="Indirizzo email" required="true">
                                <label>Indirizzo email</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input name="username" type="text" class="form-control border-top-0 border-start-0 border-end-0 border-2 border-black  border-bottom-3 rounded-0 bg-transparent no-outline" placeholder="Username" required="true">
                                <label>Username</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input id="pwd" name="password" type="password" class="form-control border-top-0 border-start-0 border-end-0 border-2 border-black  border-bottom-3 rounded-0 bg-transparent no-outline" placeholder="Password" required="true" pattern="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-:_]).{8,}$" oninvalid="this.setCustomValidity('Minimo otto caratteri, almeno una lettera maiuscola, una lettera minuscola, un numero e un carattere speciale')" oninput="this.setCustomValidity('')">
                                <label>Password</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input id="cpwd" type="password" class="form-control border-top-0 border-start-0 border-end-0 border-2 border-black  border-bottom-3 rounded-0 bg-transparent no-outline" placeholder="Conferma password" required="true">
                                <label>Conferma password</label>
                            </div>
                            <div class="row align-items-center g-3">
                                <div class="col-auto">
                                    <input type="checkbox" required="true">
                                </div>
                                <div class="col">
                                    <p class="m-0 text-start">
                                        Ho preso visione della <a href="privacy-policy" class="spa text-black">Privacy Policy</a>
                                    </p>
                                </div>
                            </div>
                            <div id="g-recaptcha" class="mt-3"></div>
                            <button type="submit" class="my-3 loader border-0 bg-black text-white p-3 text-center fw-bold text-uppercase d-block w-100 mb-3 lh-1 rounded">registrati</button>
                            <a href="login" class="spa text-black d-block">Hai già un'account? Accedi</a>
                        </form>
                        <script>
                            function initCaptcha() {
                                if (typeof grecaptcha != "undefined")
                                    grecaptcha.render('g-recaptcha', {
                                        'sitekey': '6LeW0tQiAAAAAJtx4Y8_ZZNBCXjThysFKwcj2OQd'
                                    });
                            }
                            initCaptcha();

                            var pwd = document.getElementById("pwd"),
                                cpwd = document.getElementById("cpwd");

                            function validatePassword() {
                                if (pwd.value != cpwd.value) {
                                    cpwd.setCustomValidity("Le passwords non corrispondono");
                                } else {
                                    cpwd.setCustomValidity('');
                                }
                            }
                            pwd.onchange = validatePassword;
                            cpwd.onkeyup = validatePassword;
                            $(document).ready(function() {
                                gtag('js', new Date());
                                gtag('config', 'G-F862ZC7SF3');
                            });
                        </script>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>