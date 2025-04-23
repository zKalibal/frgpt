<?php
session_start();
include_once ($webRoot = str_replace($_SERVER['PHP_SELF'], "", $_SERVER['SCRIPT_FILENAME'])) . "/php/functions.php";
$_POST = securityarray($_POST);
$_POST = htmlarray($_POST);
if ($_SESSION['user']['id'] == "") {
    //track("resetPwd");
    if ($_POST['email'] != "") {
        if (checkCaptcha($_POST['g-recaptcha-response'])) {
            if (($user = security_query("SELECT email, password from fr_users where email = [s]", array($_POST['email']))->fetch_assoc())['email'] != "") {

                $reset = sha1($user['email'] . $user['password'] . date("Y-m-d H"));

                smtpEmail("no-reply@finalround.it", "FinalRound", $_POST['email'], "Recupero password", "
        Abbiamo ricevuto la richiesta per il reset della password. Se non sei stato tu a richiederlo ignora questa email, altrimenti <a href='https://www.finalround.it/php/reset_pwd.php?reset=$reset'>clicca qui</a> per confermare la richiesta.
        ");
            }
            $alert = array(
                "style"  => "success",
                "message" => "Un email di recupero è stata inviata all'indirizzo {$_POST['email']}"
            );
            $_SESSION['alert'] = array($alert);
        } else {
            $alert = array(
                "style"  => "danger",
                "message" => "Captcha fallito!"
            );
            $_SESSION['alert'] = array($alert);
        }
    } else if ($_GET['reset'] != "") {
        $r = security_query("SELECT * from fr_users where sha1(concat(email,password,DATE_FORMAT(NOW(), '%Y-%m-%d %H'))) = [s]", array($_GET['reset']))->fetch_assoc();
        if ($r['id'] != "") {
            security_query("UPDATE fr_users set password = '' where id = [i]", array($r['id']));
            $r['password'] = "";
            login($r);
            $alert = array(
                "style"  => "success",
                "message" => "Inserisci la nuova password"
            );
            $_SESSION['alert'] = array($alert);
            redirect("../account");
        } else {
            $alert = array(
                "style"  => "danger",
                "message" => "Link non valido"
            );
            $_SESSION['alert'] = array($alert);
        }
    }
    redirect("../login");
} else redirect("../");;
