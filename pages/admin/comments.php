<?php
session_start();
include_once ($webRoot = str_replace($_SERVER['PHP_SELF'], "", $_SERVER['SCRIPT_FILENAME'])) . "/php/functions.php";
if ($_SESSION['user']['admin'] != 1) { //se non è admin
    setHeaders(["redirect" => "/"]);
} else {
    //HEADER 
    setHeaders([
        "meta-title" => "Commenti",
        "meta-robots" => "noindex"
    ]);
?>
    <div class="blur-backdrop overflow-hidden wow fadeIn">
        <?php include("include/nav.php"); ?>
        <div class="container py-4 px-3 px-lg-0">
            <?php
            foreach ($_SESSION['alert'] as $key => $value) {
            ?>
                <div class="alert alert-<?php echo $value['style']; ?> mb-4" role="alert"><?php echo $value['message']; ?></div>
            <?php
            }
            unset($_SESSION['alert']);
            ?>
            <center>
                <h2 class="fw-semibold mb-4">Commenti</h2>
            </center>

        </div>
    </div>
<?php } ?>