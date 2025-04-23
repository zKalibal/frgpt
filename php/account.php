<?php
session_start();
include_once ($webRoot = str_replace($_SERVER['PHP_SELF'], "", $_SERVER['SCRIPT_FILENAME'])) . "/php/functions.php";
$_POST = securityarray($_POST);
$_POST = htmlarray($_POST);

$password = security_query("select password from fr_users where id = {$_SESSION['user']['id']}", array())->fetch_assoc()['password'];

if ($password == "" || password_verify($_POST['password'], $password)) {

    $arr = array();
    $_SESSION['toasts'] = [];

    if ($_POST['username'] != $_SESSION['user']['username'])
        if (security_query("select username from fr_users where username = [s]", array($_POST['username']))->fetch_assoc()['username'] == "") {
            $update .= "username = [s] and ";
            array_push($arr, $_POST['username']);
        } else {
            $alert = array(
                "style"  => "danger",
                "message" => "Username già utilizzato"
            );
            $_SESSION['alert'] = array($alert);
        }

    if ($_POST['new_password'] != "" && strlen($_POST['new_password']) >= 8) {
        $update  .= "password = [s] and ";
        array_push($arr, password_hash($_POST['new_password'], PASSWORD_DEFAULT, ['cost' => 12]));
    }

    if (($update = substr($update, 0, -5)) != "") {
        security_query("update fr_users set $update where id = {$_SESSION['user']['id']}", $arr);
        login(security_query("select * from fr_users where id = {$_SESSION['user']['id']}", array())->fetch_assoc());
        $_SESSION['toasts'] = array("Account aggiornato!");
    }

    if (strpos($_FILES['photo']['type'], 'image') !== false) {
        $rotate = $_POST['photo_rotate'];
        if (upload_photo($_FILES['photo'], $webRoot . "/img/users/{$_SESSION['user']['id']}.webp", 500, $rotate))
            array_push($_SESSION['toasts'], "Foto aggiornata!");
    }
} else {
    $alert = array(
        "style"  => "danger",
        "message" => "Password errata"
    );
    $_SESSION['alert'] = array($alert);
}
redirect("../account");
