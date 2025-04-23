<?php
session_start();
include_once ($webRoot = str_replace($_SERVER['PHP_SELF'], "", $_SERVER['SCRIPT_FILENAME'])) . "/php/functions.php";
if ($post['id'] == "")
    $post['id'] = $_GET['post'];
$loaded = implode(",", $_SESSION['commentsLoaded']);

if ($_GET['reply'] != "")
    $qc = security_query("SELECT uc.username as reply_to, r.id, r.iduser, r.comment, r.date, ur.username, s.tier_id, s.tier from fr_posts_comments r inner join fr_users ur on ur.id = r.iduser inner join fr_posts_comments c on c.id = r.reply inner join fr_users uc on uc.id = c.iduser left join fr_patreon_supporters s on s.email = ur.email where r.idpost = [i] and r.reply = [i] and r.id not in ({$loaded}) order by r.date asc limit 2", array($post['id'], $_GET['reply']));
else {
    if ($loaded != "") $loaded = "and c.id not in ($loaded)";
    if ($_SESSION['user']['id'] != "") { //se l'utente è loggato
        if ($_GET['comment'] != "") { //se è indicato il parametro comment
            //ricava il commento principale (qualora sia una risposta ad un altro commento)
            $mainComment = security_query("WITH RECURSIVE CommentHierarchy AS ( SELECT id, iduser, comment, reply FROM fr_posts_comments WHERE id = [i] UNION ALL SELECT c.id, c.iduser, c.comment, c.reply FROM fr_posts_comments c INNER JOIN CommentHierarchy ch ON c.id = ch.reply ) SELECT * FROM CommentHierarchy where reply is null", [$_GET['comment']])->fetch_assoc()['id'];
            $order = "FIELD(c.id, $mainComment) DESC,"; //lo ordina per primo
        }
        $order .= "pinned desc, FIELD(c.iduser, {$_SESSION['user']['id']}) DESC,"; //poi l'ordine regolare (pinnato, propri commenti, commenti degli altri)
    }
    $qc = security_query("SELECT c.id, c.iduser, c.comment, IF(c.pinnedby is not NULL, 1,0) as pinned, p.username as pinnedby, c.date, u.username, s.tier_id, s.tier from fr_posts_comments c inner join fr_users u on u.id = c.iduser left join fr_users p on p.id = c.pinnedby left join fr_patreon_supporters s on s.email = u.email where c.idpost = [i] and c.reply is NULL $loaded order by $order c.date desc limit 10", array($post['id']));
}

if ($commentsLikes == "") { //se è il primo load comments, carica anche tutti i likes
    /* likes */
    $commentsLikes = security_query(
        "SELECT
    c.id,
    sum(case when l.type = 1 then 1 else 0 end) as likes,
    sum(case when l.type = 1 and l.iduser = '{$_SESSION['user']['id']}' then 1 else 0 end) as liked,
    sum(case when l.type = 0 then 1 else 0 end) as unlikes,
    sum(case when l.type = 0 and l.iduser = '{$_SESSION['user']['id']}' then 1 else 0 end) as unliked
    from fr_posts_comments_likes l inner join fr_posts_comments c on c.id = l.idcomment where c.idpost = [i]
    group by c.id;
    ",
        array($post['id'])
    )->fetch_all(MYSQLI_ASSOC);
    /* likes */
}


foreach ($qc->fetch_all(MYSQLI_ASSOC) as $rc) {
    $template['data'] = $rc;
    include $webRoot . "/include/templates/comment.php";
    if ($_GET['comment'] != "") break; //se è indicato il parametro comment, carica solo il commento relativo al parametro
}
