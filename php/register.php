<?php
session_start();
include_once ($webRoot = str_replace($_SERVER['PHP_SELF'], "", $_SERVER['SCRIPT_FILENAME'])) . "/php/functions.php";
security_query("delete from fr_users where status < 1 and HOUR(TIMEDIFF(NOW(), date))>2", array()); //pulisce gli account non confermati vecchi di 2+ ore

$_POST = securityarray($_POST);
$_POST = htmlarray($_POST);

if (
    $_POST['username'] != "" && strlen($_POST['username']) > 1 && strlen($_POST['username']) < 30 && //nome valido
    filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && //email valida
    $_POST['password'] != "" && strlen($_POST['password']) >= 8 //password valida
) {
    if (security_query("select username from fr_users where username = [s]", array($_POST['username']))->fetch_assoc()['username'] != "") { //se l'username è già in uso
        $alert = array(
            "style"  => "danger",
            "message" => "Username già utilizzato"
        );
        $_SESSION['alert'] = array($alert);
    } else { //se l'username è disponibile
        if (security_query("select email from fr_users where email = [s]", array($_POST['email']))->fetch_assoc()['email'] != "") { //se l'email è già in uso
            $alert = array(
                "style"  => "danger",
                "message" => "Indirizzo email già registrato"
            );
            $_SESSION['alert'] = array($alert);
        } else { //se l'email è disponibile

            // registrazione

            $password = password_hash($_POST['password'], PASSWORD_DEFAULT, ['cost' => 12]);
            security_query("insert into fr_users (username,email,password) values ([s],[s],[s])", array($_POST['username'], $_POST['email'], $password));
            //invia email con codice attivazione composto da password+status(0) in sha1. La concatenazione con lo status serve per generare un token univoco nel caso in cui venga inviata una nuova email di conferma. 
            smtpEmail("no-reply@finalround.it", "FinalRound", $_POST['email'], "Verifica indirizzo email", "
            Benvenuto su FinalRound!<br/> 
            Speriamo che il nostro approccio, trasparente e diverso dal solito, possa dare una sferzata al mondo dell’editoria videoludica anche grazie al tuo supporto. Per contribuire alla discussione nella nostra community ti resta solo un passaggio:<br/><br/> 

            <a href='https://www.finalround.it/php/confirm_email.php?verify=" . sha1($password . "0") . "'>Verifica l'Account</a><br/><br/>

            Ricorda di rispettare gli utenti e non esagerare nei toni, per non far intervenire i moderatori!
            ");
            redirect("../registrazione?verify-sent=" . $_POST['email']);

            // registrazione
        }
    }
} else {
    $alert = array(
        "type"  => "error",
        "message" => "Si è verificato un'errore."
    );
    array_push($_SESSION['alert'], $alert);
}
redirect("../registrazione");
