<?php
session_start();
include_once ($webRoot = str_replace($_SERVER['PHP_SELF'], "", $_SERVER['SCRIPT_FILENAME'])) . "/php/functions.php";

//HEADER 
setHeaders([
    "meta-title" => "Patreon supporters",
    "meta-robots" => "noindex"
]);

/* TRACCIA SOLO SE E' UN LINK SPA ALTRIMENTI HA GIA' TRACCIATO LA INDEX.PHP, SE E' ARRIVATO FIN QUI VUOL DIRE CHE E' SAFE*/
if ($_POST['spa']) security_uri($_POST['urlrewrite']);
/* TRACCIA SOLO SE E' UN LINK SPA ALTRIMENTI HA GIA' TRACCIATO LA INDEX.PHP, SE E' ARRIVATO FIN QUI VUOL DIRE CHE E' SAFE*/
?>
<div class="blur-backdrop overflow-hidden wow fadeIn">
    <div class="container py-4 px-3 px-lg-0">
        <h2 class="fw-semibold mb-4 text-center">Patreon supporter</h2>
        <hr>
        <?php
        $qcat = security_query("SELECT tier, tier_id from fr_patreon_supporters group by tier_id order by tier_id desc;", []);
        while ($rcat = $qcat->fetch_assoc()) {
            $q = security_query("SELECT u.username, u.id as iduser, s.* from fr_patreon_supporters s left join fr_users u on u.email = s.email where s.tier_id = {$rcat['tier_id']} order by s.campaign_lifetime_support_cents desc", []);
        ?>
            <h5 class="fw-semibold mt-5 mb-3 text-center"><?php echo $rcat['tier']; ?></h5>
            <div class="row justify-content-center align-items-center g-2">
                <?php
                if (mysqli_num_rows($q)) {
                    while ($r = $q->fetch_assoc()) {
                        if ($r['iduser'] != "") {
                ?>
                            <div class="col-auto">
                                <a href="<?php echo "user/{$r['iduser']}/" . strtourl($r['username']); ?>" role="button" class="spa d-inline-flex text-decoration-none text-black hstack gap-0 bg-primary bg-opacity-10 rounded-pill shadow-sm">
                                    <?php if (file_exists($webRoot . '/img/users/' .  $r['iduser'] . '.webp')) { ?>
                                        <div>
                                            <div class="ratio ratio-1x1" style="width:45px">
                                                <div class="img rounded-circle bg-black bg-opacity-10" style="background-size:cover;background-position:center;background-image: url('/img/users/<?php echo  $r['iduser']; ?>.webp');"></div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="p-2"><?php echo getPatreonBadge($r['tier_id'], $r['tier']); ?><b><?php echo $r['full_name']; ?></b></div>
                                </a>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="col-auto">
                                <div class="text-decoration-none text-black bg-light shadow-sm p-2 rounded-pill">
                                    <?php echo getPatreonBadge($r['tier_id'], $r['tier']); ?><b><?php echo $r['full_name']; ?></b>
                                </div>
                            </div>
                    <?php
                        }
                    }
                } else {
                    ?>
                    <p class="text-center bg-primary bg-opacity-10 p-2 rounded fw-bold">Nessun supporter</p>
                <?php
                }
                ?>
            </div>
        <?php
        }
        ?>

    </div>
</div>
<script>
    $(document).ready(function() {
        gtag('js', new Date());
        gtag('config', 'G-F862ZC7SF3');
    });
</script>