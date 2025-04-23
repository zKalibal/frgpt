<?php
session_start();
include_once ($webRoot = str_replace($_SERVER['PHP_SELF'], "", $_SERVER['SCRIPT_FILENAME'])) . "/php/functions.php";
if ($_SESSION['user']['id'] != "") {
    security_query("UPDATE fr_users_notifications set seen = 1 where iduser = {$_SESSION['user']['id']}", []); //segna tutte le notifiche come lette
    $r = security_query("SELECT * FROM fr_users_notifications where iduser = {$_SESSION['user']['id']} order by date desc limit 5", array()); //carica le notifiche
    if ($r->num_rows > 0) {
        while ($rc = $r->fetch_assoc()) {
?>
            <a href="<?php echo $rc['link']; ?>" class="spa text-decoration-none bg-primary bg-opacity-10 text-black p-2 rounded lh-1 text-wrap small fw-normal">
                <p class="mb-1"><?php echo $rc['message']; ?></p>
                <span class="d-block small">
                    <?php echo timePassed($rc['date']); ?>
                </span>
            </a>
        <?php
        }
    } else {
        ?>
        <p class="m-0">
            Non ci sono nuove notifiche
        </p>
<?php
    }
}
?>