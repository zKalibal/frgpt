<?php
session_start();
include_once ($webRoot = str_replace($_SERVER['PHP_SELF'], "", $_SERVER['SCRIPT_FILENAME'])) . "/php/functions.php";
if ($_SESSION['user']['id'] != "") {
    if (security_query("SELECT iduser from fr_users_bans where iduser = [i]", array($_SESSION['user']['id']))->fetch_assoc()['iduser'] == "") {
        if (security_query("SELECT * from fr_users_favorites where idpost = [i] and iduser = {$_SESSION['user']['id']}", [$_GET['id']])->fetch_assoc()['id'] == "") {
            security_query("INSERT into fr_users_favorites (idpost,iduser) VALUES ([i],{$_SESSION['user']['id']})", [$_GET['id']]);
        } else {
            security_query("DELETE from fr_users_favorites where idpost = [i] and iduser = {$_SESSION['user']['id']}", [$_GET['id']]);
        }
        echo security_query("SELECT count(id) as count from fr_users_favorites where idpost = [i]", [$_GET['id']])->fetch_assoc()['count'];
    } else {
        header("error: Sei bannato");
    }
} else header("error: Per aggiungere ai preferiti effettua l'accesso");
