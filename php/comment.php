<?php
session_start();
include_once ($webRoot = str_replace($_SERVER['PHP_SELF'], "", $_SERVER['SCRIPT_FILENAME'])) . "/php/functions.php";
if (false) {
    $error = "Commenti disabilitati";
    header('error: ' . $error);
} else
if ($_SESSION['user']['id'] != "") {
    if (security_query("SELECT iduser from fr_users_bans where iduser = [i]", array($_SESSION['user']['id']))->fetch_assoc()['iduser'] == "") {
        if (($post = security_query("SELECT id, title, type from fr_posts where id = [i]", array($_GET['post']))->fetch_assoc())['id'] != "") {

            if ($_POST['edit'] != "") { //se è una modifica del proprio post
                security_query("UPDATE fr_posts_comments set comment = [s] where id = [i] and iduser = {$_SESSION['user']['id']}", array($_POST['comment'], $_POST['edit']));
                $comment = security_query("SELECT c.comment from fr_posts_comments c where c.id = [i]", array($_POST['edit']))->fetch_assoc()['comment'];
                echo nl2br(htmlentities($comment));
            } else {
                /* snippet per determinare la profondità del commento, se è la profondità massima (3), risponde al commento precedente (2)*/
                if ($_POST['reply'] != "") {
                    $reply[$depth = 1] = $_POST['reply'];
                    $qs = security_query("SELECT reply from fr_posts_comments where id = {$_POST['reply']}", array());
                    while ($rs = $qs->fetch_assoc()) { //cerca se il commento è una risposta ad un'altro commento
                        if ($rs['reply'] != NULL) { //se lo trova, lo assegna ad un array che traccia l'id del commento e la profondità
                            $depth++;
                            $reply[$depth] = $rs['reply'];
                            $qs = security_query("SELECT reply from fr_posts_comments where id = {$rs['reply']}", array());
                        }
                    }
                    $_POST['reply'] = array_slice($reply, -2, 2)[0]; //nel caso in cui si vuole rispondere ad un commento al terzo e ultimo livello, stonca l'array e forza la risposta al secondo livello

                    //notifica a tutti gli utenti che hanno commentato il post
                    $qn = security_query("WITH RECURSIVE CommentHierarchy AS ( SELECT id, iduser, comment, reply FROM fr_posts_comments WHERE id = [i] UNION ALL SELECT c.id, c.iduser, c.comment, c.reply FROM fr_posts_comments c INNER JOIN CommentHierarchy ch ON c.id = ch.reply ) SELECT DISTINCT iduser FROM CommentHierarchy where iduser <> {$_SESSION['user']['id']}", [$_POST['reply']]);
                    $url = ["notizie", "recensioni", "monografie", "anteprime"][$post['type']] . "/{$post['id']}/" . strtourl($post['title']) . "?comment={$_POST['reply']}#comment";
                    while ($rn = $qn->fetch_assoc()) {
                        security_query("INSERT into fr_users_notifications (iduser, message, link) values([i],[s],[s])", [$rn['iduser'], "<b>{$_SESSION['user']['username']}</b> ha risposto ad un commento", $url]);
                    }
                }
                /* snippet per determinare la profondità del commento, se è la profondità massima (2), risponde al commento precedente*/

                security_query("INSERT into fr_posts_comments (idpost,iduser,comment,reply) values([i],{$_SESSION['user']['id']},[s],[i])", array($_GET['post'], $_POST['comment'], $_POST['reply']));
                $template['data'] = security_query("SELECT  c.id, c.iduser, c.comment, c.date, uc.username, ur.username as reply_to, s.tier_id, s.tier from fr_posts_comments c inner join fr_users uc on uc.id = c.iduser left join fr_posts_comments r on r.id = c.reply left join fr_users ur on ur.id = r.iduser left join fr_patreon_supporters s on s.email = uc.email where c.iduser = {$_SESSION['user']['id']} and c.idpost = [i] order by c.id desc limit 1", array($_GET['post']))->fetch_assoc();
                include $webRoot . "/include/templates/comment.php";
            }
        } else {
            $error = "Articolo non trovato!";
            header('error: ' . $error);
        }
    } else {
        $error = "Sei bannato";
        header('error: ' . $error);
    }
} else {
    $error = "Per commentare devi effettuare l'accesso";
    header('error: ' . $error);
}
