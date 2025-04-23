<?php
session_start();
include_once ($webRoot = str_replace($_SERVER['PHP_SELF'], "", $_SERVER['SCRIPT_FILENAME'])) . "/php/functions.php";
if ($_SESSION['user']['admin'] != 1) { //se non è admin
    setHeaders(["redirect" => "/"]);
} else {
    //HEADER 
    setHeaders([
        "meta-title" => "Statistiche",
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
                <h2 class="fw-semibold mb-4">Statistiche</h2>
            </center>
            <?php

            $stats =  security_query(
                "SELECT 
                (select count(id) from fr_posts_comments) as comments,
                (select count(id) from fr_posts_comments_likes) as reactions,
                (SELECT count(id) FROM fr_tracks) as views,
                (
                    SELECT count(id) FROM fr_tracks WHERE 
                    (
                        uri REGEXP [s] 
                    )
                ) as fbviews,
                (select count(distinct ip) from fr_tracks) as unique_views,
                (select count(id) from fr_users where status = 1) as users
            ",
                ["/?fbclid=[a-zA-Z0-9\-\_]*$"]
            )->fetch_assoc();
            ?>
            <div class="row g-4">
                <div class="col-4">
                    <div class="p-4 bg-primary bg-opacity-10 text-center">
                        <label class="fw-bold">Visite totali</label>
                        <h2 class="m-0"><?php echo $stats['views']; ?></h2>
                    </div>
                </div>
                <div class="col-4">
                    <div class="p-4 bg-primary bg-opacity-10 text-center">
                        <label class="fw-bold">Visite uniche</label>
                        <h2 class="m-0"><?php echo $stats['unique_views']; ?></h2>
                    </div>
                </div>
                <div class="col-4">
                    <div class="p-4 bg-primary bg-opacity-10 text-center">
                        <label class="fw-bold">Da fb (uniche)</label>
                        <h2 class="m-0"><?php echo $stats['fbviews']; ?></h2>
                    </div>
                </div>
                <div class="col-4">
                    <div class="p-4 bg-primary bg-opacity-10 text-center">
                        <label class="fw-bold">Commenti</label>
                        <h2 class="m-0"><?php echo $stats['comments']; ?></h2>
                    </div>
                </div>
                <div class="col-4">
                    <div class="p-4 bg-primary bg-opacity-10 text-center">
                        <label class="fw-bold">Reazioni</label>
                        <h2 class="m-0"><?php echo $stats['reactions']; ?></h2>
                    </div>
                </div>
                <div class="col-4">
                    <div class="p-4 bg-primary bg-opacity-10 text-center">
                        <label class="fw-bold">Utenti</label>
                        <h2 class="m-0"><?php echo $stats['users']; ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>