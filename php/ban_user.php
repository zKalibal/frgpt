<?php
session_start();
include_once ($webRoot = str_replace($_SERVER['PHP_SELF'], "", $_SERVER['SCRIPT_FILENAME'])) . "/php/functions.php";

if ($_SESSION['user']['admin'] || in_array($_SESSION['user']['id'], $mods)) {
    $iduser = security_query("SELECT iduser from fr_users_bans where iduser = [i]", array($_GET['id']))->fetch_assoc()['iduser'];
    if ($iduser != NULL) {
        //track("unbanUser");
        security_query("DELETE from fr_users_bans where iduser = [i]", array($_GET['id']));
        $toast = "Utente sbannato";
    } else {
        //track("banUser");
        security_query("INSERT into fr_users_bans (iduser) values ([i])", array($_GET['id']));
        security_query("DELETE from fr_posts_comments WHERE iduser = [i]", array($_GET['id']));
        security_query("DELETE from fr_posts_comments_likes WHERE iduser = [i]", array($_GET['id']));
        $toast = "Utente bannato";
    }
} else {
    $toast = "Non autorizzato";
}
echo $toast;
