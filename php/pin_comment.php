<?php
session_start();
include_once ($webRoot = str_replace($_SERVER['PHP_SELF'], "", $_SERVER['SCRIPT_FILENAME'])) . "/php/functions.php";
if ($_SESSION['user']['admin'] || in_array($_SESSION['user']['id'], $mods)) {
    $pinned = security_query("SELECT pinnedby from fr_posts_comments where id = [i]", array($_GET['id']))->fetch_assoc()['pinnedby'];
    if ($pinned != NULL) {
        $pinned = "NULL";
        $toast = "Commento unpinnato";
    } else {
        $pinned = $_SESSION['user']['id'];
        $toast = "Commento pinnato";
    }
    security_query("UPDATE fr_posts_comments set pinnedby = {$pinned} where id = [i]", array($_GET['id']));
} else {
    $toast = "Non autorizzato";
}
echo $toast;
