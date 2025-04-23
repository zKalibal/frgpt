<?php
session_start();
include_once ($webRoot = str_replace($_SERVER['PHP_SELF'], "", $_SERVER['SCRIPT_FILENAME'])) . "/php/functions.php";
if ($_SESSION['user']['id'] != "") {
    if (in_array($_GET['type'], [0, 1])) { //if type is 0 or 1
        if (security_query("SELECT iduser from fr_users_bans where iduser = [i]", array($_SESSION['user']['id']))->fetch_assoc()['iduser'] == "") {
            $like = security_query("SELECT * from fr_posts_comments_likes where idcomment = [i] and iduser = {$_SESSION['user']['id']}", array($_GET['id']))->fetch_assoc();
            if ($like['id'] == "") {
                security_query("INSERT into fr_posts_comments_likes (idcomment,iduser,type) VALUES ([i],{$_SESSION['user']['id']},[i])", array($_GET['id'], $_GET['type']));
                echo "like";
            } else {
                if ($_GET['type'] == $like['type']) {
                    security_query("DELETE from fr_posts_comments_likes where idcomment = [i] and iduser = {$_SESSION['user']['id']}", array($_GET['id']));
                    echo "unlike";
                } else {
                    security_query("UPDATE fr_posts_comments_likes set type = [i] where idcomment = [i] and iduser = {$_SESSION['user']['id']}", array($_GET['type'], $_GET['id']));
                    echo "like";
                }
            }
            //insert or update notification
            $comment = security_query("SELECT pc.iduser as author, p.type as typepost, p.id as idpost, p.title as titlepost from fr_posts_comments pc inner join fr_posts p on p.id = pc.idpost where pc.id = [i]", [$_GET['id']])->fetch_assoc();
            $url = ["notizie", "recensioni", "monografie", "anteprime"][$comment['typepost']] . "/{$comment['idpost']}/" . strtourl($comment['titlepost']) . "?comment={$_GET['id']}&reaction#comment";
            security_query("DELETE from fr_users_notifications where iduser = [i] and link = [s]", [$comment['author'], $url]); //delete previous same notification (like or unlike)
            if ($_GET['type'] != $like['type']) //if is a new reaction (and not a cancel of the previous one)
            {
                security_query("INSERT into fr_users_notifications (iduser, message, link) values([i],[s],[s])", [
                    $comment['author'],
                    ($_GET['type'] == 1 ? "A <b>{$_SESSION['user']['username']}</b> piace il tuo commento" : "A <b>{$_SESSION['user']['username']}</b> non piace il tuo commento"),
                    $url
                ]);
            }
        } else {
            header('error: Sei bannato');
        }
    }
} else header("error: Per reagire devi effettuare l'accesso");
