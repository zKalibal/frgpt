<?php
session_start();
include_once ($webRoot = str_replace($_SERVER['PHP_SELF'], "", $_SERVER['SCRIPT_FILENAME'])) . "/php/functions.php";
if ($_SESSION['user']['id'] == "") { //se non è loggato
    setHeaders(["redirect" => "/"]);
} else {
    
    //HEADER 
    setHeaders([
        "meta-title" => "Account utente",
        "meta-robots" => "noindex"
    ]);

    /* TRACCIA SOLO SE E' UN LINK SPA ALTRIMENTI HA GIA' TRACCIATO LA INDEX.PHP, SE E' ARRIVATO FIN QUI VUOL DIRE CHE E' SAFE*/
    if ($_POST['spa']) security_uri($_POST['urlrewrite']);
    /* TRACCIA SOLO SE E' UN LINK SPA ALTRIMENTI HA GIA' TRACCIATO LA INDEX.PHP, SE E' ARRIVATO FIN QUI VUOL DIRE CHE E' SAFE*/
?>
    <div class="blur-backdrop overflow-hidden wow fadeIn">
        <div class="container py-4 px-3 px-lg-0">
            <div class="row justify-content-center">
                <div class="col-12 col-md-5 text-center">
                    <?php
                    foreach ($_SESSION['alert'] as $key => $value) {
                    ?>
                        <div class="alert alert-<?php echo $value['style']; ?> mb-4" role="alert"><?php echo $value['message']; ?></div>
                    <?php
                    }
                    unset($_SESSION['alert']);
                    ?>
                    <div class="mb-4">
                        <h2 class="fw-semibold m-0">Account utente</h2>
                        <p><?php echo $_SESSION['user']['email']; ?></p>
                        <?php if ($_SESSION['user']['twitch_data'] == "") {
                        ?>
                            <a class="loader mt-2 border-0 bg-twitch p-2 lh-1 text-white text-decoration-none fw-bold d-inline-block rounded" href="https://id.twitch.tv/oauth2/authorize?client_id=<?php echo $twitch_client_id; ?>&redirect_uri=<?php echo $twitch_redirect_uri; ?>&response_type=code&scope=user:read:email+user:read:subscriptions"><i class="bi bi-twitch"></i> Collega Twitch</a>
                        <?php
                        } else { ?>
                            <a href="php/twitch_login.php?logout" class="loader mt-2 border-0 bg-danger p-2 lh-1 text-white text-decoration-none fw-bold d-inline-block rounded"><i class="bi bi-twitch"></i> dissocia <?php echo $_SESSION['user']['twitch_data']['display_name']; ?></a>
                        <?php }
                        ?>
                    </div>
                    <form method="post" enctype="multipart/form-data" action="php/account.php">
                        <center class="mb-3">
                            <a href="javascript:void(0)" class="d-block text-black text-decoration-none" onclick="$(this).next().click();">
                                <div class="ratio ratio-1x1 w-50">
                                    <div class="img rounded-circle bg-black bg-opacity-10" style="background-size:cover;background-position:center;<?php if (file_exists($webRoot . '/img/users/' . $_SESSION['user']['id'] . '.webp')) { ?> background-image: url('/img/users/<?php echo $_SESSION['user']['id']; ?>.webp?t=<?php echo filemtime($webRoot . '/img/users/' . $_SESSION['user']['id'] . '.webp'); ?>');<?php } ?>"></div>
                                    <span>
                                        <label role="button" class="d-block fw-bold text-white lh-1 position-absolute top-50 start-50 translate-middle w-100" style="text-shadow: 0 0 10px #000;">Scegli foto</label>
                                    </span>
                                </div>
                            </a>
                            <input name="photo" type="file" hidden="true" onchange="$(this).next().show().prev().prev().find('.rounded-circle').css('background-image', 'url(' + window.URL.createObjectURL(this.files[0]) + ')');">
                            <a href="javascript:void(0)" class="bg-black fs-3 p-2 d-inline-block mt-2 text-white lh-1 rounded-circle" style="display:none!important;" onclick="if(rotate==360) rotate = 0; else rotate+=90; $(this).next().val(rotate); $(this).closest('center').find('.rounded-circle').css('transform','rotate('+rotate+'deg)');">
                                <i class="bi bi-arrow-clockwise"></i>
                            </a>
                            <input name="photo_rotate" value="0" hidden>
                            <script>
                                var rotate = 0;
                            </script>
                        </center>
                        <div class="form-floating mb-3">
                            <input name="username" value="<?php echo $_SESSION['user']['username']; ?>" type="text" class="form-control border-top-0 border-start-0 border-end-0 border-2 border-black  border-bottom-3 rounded-0 bg-transparent no-outline" placeholder="Username" required="true">
                            <label>Username</label>
                        </div>
                        <?php if ($_SESSION['user']['password'] != -1) { ?>
                            <div class="form-floating mb-3">
                                <input name="password" type="password" class="form-control border-top-0 border-start-0 border-end-0 border-2 border-black  border-bottom-3 rounded-0 bg-transparent no-outline" placeholder="Password attuale" required="true">
                                <label>Password attuale</label>
                            </div>
                        <?php } ?>
                        <div class="form-floating mb-3">
                            <input id="pwd" name="new_password" type="password" class="form-control border-top-0 border-start-0 border-end-0 border-2 border-black  border-bottom-3 rounded-0 bg-transparent no-outline" placeholder="Nuova password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" oninvalid="this.setCustomValidity('Minimo otto caratteri, almeno una lettera maiuscola, una lettera minuscola, un numero e un carattere speciale')" oninput="this.setCustomValidity('')">
                            <label>Nuova password</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input id="cpwd" type="password" class="form-control border-top-0 border-start-0 border-end-0 border-2 border-black  border-bottom-3 rounded-0 bg-transparent no-outline" placeholder="Conferma password">
                            <label>Conferma password</label>
                        </div>
                        <script>
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
                        <button type="submit" class="loader border-0 bg-black text-white p-3 text-center fw-bold text-uppercase d-block w-100 mb-3 lh-1 rounded">salva modifiche</button>
                        <a href="php/logout.php" class="mb-3 text-black d-block">Disconnetti account</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>