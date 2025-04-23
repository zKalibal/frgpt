<?php
session_start();
include "functions.php";
$_POST = securityarray($_POST);
$_POST = htmlarray($_POST);
if (checkCaptcha($_POST['g-recaptcha-response'])) {
    if ($_POST['email'] != "" && $_POST['password'] != "") {
        $r = security_query("select * from fr_users where email = [s] and status = 1", array($_POST['email']))->fetch_assoc();
        if (password_verify($_POST['password'], $r['password'])) {
            login($r);
            redirect($_SESSION['redirect']);
        } else {
            $alert = array(
                "style"  => "danger",
                "message" => "Email o password errate!"
            );
            $_SESSION['alert'] = array($alert);
        }
    }
} else {
    $alert = array(
        "style"  => "danger",
        "message" => "Captcha fallito!"
    );
    $_SESSION['alert'] = array($alert);
}
redirect("../login");
