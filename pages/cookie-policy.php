<?php
session_start();
include_once ($webRoot = str_replace($_SERVER['PHP_SELF'], "", $_SERVER['SCRIPT_FILENAME'])) . "/php/functions.php";

//HEADER 
setHeaders([
    "meta-title" => "Cookie Policy",
    "meta-robots" => "noindex"
]);

/* TRACCIA SOLO SE E' UN LINK SPA ALTRIMENTI HA GIA' TRACCIATO LA INDEX.PHP, SE E' ARRIVATO FIN QUI VUOL DIRE CHE E' SAFE*/
if ($_POST['spa']) security_uri($_POST['urlrewrite']);
/* TRACCIA SOLO SE E' UN LINK SPA ALTRIMENTI HA GIA' TRACCIATO LA INDEX.PHP, SE E' ARRIVATO FIN QUI VUOL DIRE CHE E' SAFE*/
?>
<div class="blur-backdrop overflow-hidden wow fadeIn">
    <div class="container py-4 px-3 px-lg-0">
        <h2 class="fw-semibold mb-4 text-center">Cookie Policy</h2>
        <hr />
        <script id="CookieDeclaration" src="https://consent.cookiebot.com/b1fda898-d90c-4dea-b3fe-0354569ba155/cd.js" type="text/javascript" async></script>
    </div>
</div>
<script>
    $(document).ready(function() {
        gtag('js', new Date());
        gtag('config', 'G-F862ZC7SF3');
    });
</script>