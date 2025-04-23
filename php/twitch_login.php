<?php
session_start();
include "functions.php";
if (isset($_GET['logout'])) {
    if ($_SESSION['user']['password'] != -1) {
        security_query("update fr_users set twitch_data = NULL where id = {$_SESSION['user']['id']}", array());
        login(security_query("select * from fr_users where id = {$_SESSION['user']['id']}", array())->fetch_assoc());
    } else
        $_SESSION['toasts'] = array("Imposta una password per dissociare Twitch");
    redirect("/account");
} else if ($_GET['code'] != "") {
    $result = curl_call("https://id.twitch.tv/oauth2/token?client_id=$twitch_client_id&client_secret=$twitch_client_secret&code={$_GET['code']}&grant_type=authorization_code&redirect_uri=$twitch_redirect_uri", "POST");

    $user_info = twitch_GetUsers("", $result['access_token'])['data']['0'];
    unset($result['token_type'], $result['scope']);
    $result['id'] = $user_info['id'];
    $result['expires_in'] += time();
    $result['display_name'] = $user_info['display_name'];
    $data = json_encode($result);

    if ($user_info['id'] != "") {

        //verifico se esiste un account con questo ID twitch
        $iduser = security_query("select id from fr_users where json_extract(twitch_data, '$.id') = '{$user_info['id']}'", array())->fetch_assoc()['id'];

        if ($_SESSION['user']['id'] == "") { //se l'utente è sloggato

            if ($iduser == "") //e non trova alcuna corrispondenza con l'ID twitch - registra il nuovo utente
            {
                $_SESSION['toasts'] = array("Accesso con twitch");
                if (security_query("select email from fr_users where email = '{$user_info['email']}'", array())->fetch_assoc()['email'] == "") { //controllo email già utilizzata

                    //check su username, in caso di doppione aggiunge un numero progressivo ;)
                    $username = $check = $user_info['display_name'];
                    do {
                        $check = $username . $i++;
                    } while ($r = security_query("select id from fr_users where username = '$check'", array())->fetch_assoc()['id'] != "");
                    //

                    security_query("insert into fr_users (username,email,twitch_data,status) values ('$username','{$user_info['email']}', [s], 1)", array($data));
                    login(security_query("select * from fr_users where email = [s] and status = 1", array($user_info['email']))->fetch_assoc());
                } else {
                    $_SESSION['toasts'] = array("Email twitch già utilizzata");
                    redirect("/login");
                }
            } else //se trova un'utente con questo id twitch, lo logga
            {
                security_query("update fr_users set twitch_data = [s] where id = {$iduser}", array($data));
                login(security_query("select * from fr_users where id = {$iduser}", array())->fetch_assoc());
            }
            redirect($_SESSION['redirect']);
        } else if ($_SESSION['user']['id'] == $iduser || $iduser == "") { //se l'utente non è sloggato e trova corrispondenza o non trova nulla, associa/aggiorna i dati twitch

            security_query("update fr_users set twitch_data = [s] where id = {$_SESSION['user']['id']}", array($data));
            login(security_query("select * from fr_users where id = {$_SESSION['user']['id']}", array())->fetch_assoc());
            $_SESSION['toasts'] = array("Account Twitch associato");
            redirect("/account");
        } else $_SESSION['toasts'] = array("Account Twitch già utilizzato");
    }
} else $_SESSION['toasts'] = array("Qualcosa è andato storto");

redirect("/");
