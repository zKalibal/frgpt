<?php
session_start();
include_once ($webRoot = str_replace($_SERVER['PHP_SELF'], "", $_SERVER['SCRIPT_FILENAME'])) . "/php/functions.php";
if ($_SESSION['user']['id'] != "") {
    if (!$_SESSION['user']['admin'] && !in_array($_SESSION['user']['id'], $mods)) $filter = "and iduser = {$_SESSION['user']['id']}";
    if (security_query("select id from fr_posts_comments where id = [i] $filter", array($_GET['id']))->fetch_assoc()['id'] != "") {
        security_query("DELETE from fr_posts_comments WHERE id = [i]", array($_GET['id']));
    } else
        header('error: Commento non trovato');
} else
    header('error: Non sei autenticato');
