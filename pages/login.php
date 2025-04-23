<?php
session_start();
include_once ($webRoot = str_replace($_SERVER['PHP_SELF'], "", $_SERVER['SCRIPT_FILENAME'])) . "/php/functions.php";
if ($_SESSION['user']['id'] != "") { //se è già loggato
    setHeaders(["redirect" => "/"]);
} else {
    
    //HEADER 
    setHeaders([
        "meta-title" => "Login",
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
                    foreach ($_SESSION['alert'] as $key => $value) {
                    ?>
                        <div class="alert alert-<?php echo $value['style']; ?> mb-4" role="alert"><?php echo $value['message']; ?></div>
                    <?php
                    }
                    unset($_SESSION['alert']);
                    ?>
                    <h2 class="fw-semibold mb-4">Effettua l'accesso</h2>
                    <form action="php/login.php" method="post" class="captcha">
                        <input name="g-recaptcha-response" hidden="true">
                        <div class="form-floating mb-3">
                            <input name="email" type="email" class="form-control border-top-0 border-start-0 border-end-0 border-2 border-black  border-bottom-3 rounded-0 bg-transparent no-outline" placeholder="Indirizzo email" required="true">
                            <label>Indirizzo email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="password" type="password" class="form-control border-top-0 border-start-0 border-end-0 border-2 border-black  border-bottom-3 rounded-0 bg-transparent no-outline" placeholder="Indirizzo email" required="true">
                            <label>Password</label>
                        </div>
                        <a href="javascript:void(0)" onclick="modal('Password dimenticata','include/modals/forgotpwd.php',2,'modal-md',false);" class="mb-3 text-black d-block">Hai dimenticato la password?</a>
                        <div id="g-recaptcha" class="mb-3"></div>
                        <button type="submit" class="loader border-0 bg-black text-white p-3 text-center fw-bold text-uppercase d-block w-100 mb-3 lh-1 rounded">accedi</button>
                        <a href="https://id.twitch.tv/oauth2/authorize?client_id=<?php echo $twitch_client_id; ?>&redirect_uri=<?php echo $twitch_redirect_uri; ?>&response_type=code&scope=user:read:email+user:read:subscriptions" class="loader border-0 bg-twitch text-white p-3 text-center fw-bold text-uppercase text-decoration-none d-block w-100 mb-3 lh-1 rounded"><i class="bi bi-twitch"></i> accedi con twitch</a>
                        <a href="registrazione" class="text-black d-block spa">Crea il tuo account</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function initCaptcha() {
            if (typeof grecaptcha != "undefined")
                grecaptcha.render('g-recaptcha', {
                    'sitekey': '6LeW0tQiAAAAAJtx4Y8_ZZNBCXjThysFKwcj2OQd'
                });
        }
        initCaptcha();
        $(document).ready(function() {
            gtag('js', new Date());
            gtag('config', 'G-F862ZC7SF3');
        });
    </script>
<?php } ?>