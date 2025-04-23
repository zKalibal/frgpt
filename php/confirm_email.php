<?php
session_start();
include "functions.php";
if ($_GET['resend'] != "") {

    $verify = security_query("select password,status from fr_users where email = [s]", array($_GET['resend']))->fetch_assoc();
    if ($verify['password'] != "" && $verify['status'] == 0) { //verifico che non sia già stato effettuato un resend e che l'utente sia nel db
        //aggiorno status -1 in modo che il link di conferma precedente risulti invalidato
        security_query("update fr_users set status = status-1 where email = [s]", array($_GET['resend']));
        //genero un nuovo link di conferma combinando pw + status
        $verify['status']--;
        $verify = sha1($verify['password'] . $verify['status']);
        smtpEmail("no-reply@finalround.it", "FinalRound", $_GET['resend'], "Verifica indirizzo email", "Per verificare l'indirizzo email e attivare il tuo account <a href='https://www.finalround.it/php/confirm_email.php?verify={$verify}'>clicca qui</a>");
        redirect("../registrazione?verify-sent");
    }
} else {
    //verifico che il codice di verifica sia valido e coincida con lo status attuale (0 o -1 in caso di reinvio)
    $r = security_query("select * from fr_users where sha1(concat(password,status)) = [s] and status <=0", array($_GET['verify']))->fetch_assoc();
    if ($r['id'] != "") {
        security_query("update fr_users set status = 1 where email = [s]", array($r['email']));
        //email verificata
        login($r);
        $_SESSION['toasts'] = array("Account verificato!");
    } else $_SESSION['toasts'] = array("Link di verifica non valido!");
}
redirect("/");
