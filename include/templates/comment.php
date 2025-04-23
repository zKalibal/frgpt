<?php array_push($_SESSION['commentsLoaded'], $template['data']['id']); ?>
<div class="comment-<?php echo $template['data']['id']; ?> row gx-1 gx-lg-3 mt-3 position-relative">
    <div class="col-auto">
        <div class="mb-2 img user position-relative ratio ratio-1x1 rounded-circle border border-2 border-light shadow-sm" style="width:45px; <?php if (file_exists($webRoot . '/img/users/' .  $template['data']['iduser'] . '.webp')) { ?> background-image: url('/img/users/<?php echo  $template['data']['iduser']; ?>.webp');<?php } ?>"></div>
    </div>
    <div class="col <?php if ($template['version'] == "homepage") echo "text-truncate"; ?>">
        <?php if ($template['data']['pinnedby'] != "") { ?>
            <small class="fw-bold mb-1 d-block"><i class="bi bi-fire text-primary"></i> Messo in evidenza da <?php echo $template['data']['pinnedby']; ?></small>
        <?php } ?>
        <div class="bg-primary <?php echo ($_GET['comment'] == $template['data']['id']) ? "bg-opacity-25" : "bg-opacity-10"; ?> rounded p-2 px-lg-3 <?php if ($template['version'] != "homepage") echo "d-inline-block"; ?> message text-break">
            <?php
            if ($template['version'] == "homepage") {
            ?>
                <a class="spa text-decoration-none text-black d-block text-truncate" href="<?php echo ["notizie", "recensioni", "monografie", "anteprime"][$template['data']['type']]; ?>/<?php echo $template['data']['id']; ?>/<?php echo strtourl($template['data']['title']); ?>" rel="nofollow">
                    <?php echo getPatreonBadge($template['data']['tier_id'], $template['data']['tier']); ?> <b class="fw-bold"><?php echo $template['data']['username']; ?></b> <i class="bi bi-arrow-right"></i> <?php echo $template['data']['title']; ?>
                </a>
            <?php
            } else {
            ?>
                <div class="hstack gap-3">
                    <div>
                        <label>
                            <h6 class="message_from d-inline-block fw-bold"><?php echo getPatreonBadge($template['data']['tier_id'], $template['data']['tier']); ?><a class="spa text-decoration-none text-black" href="<?php echo "user/{$template['data']['iduser']}/" . strtourl($template['data']['username']); ?>"><?php echo $template['data']['username']; ?></a></h6> - <span class="small" title="<?php echo date("d/m/Y H:i:s", strtotime($template['data']['date'])); ?>"><?php echo timePassed($template['data']['date']); ?></span>
                        </label>
                    </div>
                    <?php if ($_SESSION['user']['id'] != "" && ($template['data']['iduser'] == $_SESSION['user']['id'] || $_SESSION['user']['admin'] || in_array($_SESSION['user']['id'], $mods))) { ?>
                        <div class="ms-auto">
                            <div class="dropdown">
                                <a href="#" role="button" class="d-block text-decoration-none text-black" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots"></i>
                                </a>
                                <ul class="dropdown-menu  overflow-hidden p-0 py-2 shadow fw-bold text-nowrap">
                                    <?php if ($_SESSION['user']['admin'] || in_array($_SESSION['user']['id'], $mods)) {
                                    ?>
                                        <li>
                                            <a href="javascript:void(0)" onclick="pinComment(<?php echo $template['data']['id']; ?>);" class="text-black text-decoration-none d-block p-1 px-3"><i class="bi bi-fire"></i> Metti in evidenza</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)" onclick="if(confirm('Confermi di voler bannare <?php echo $template['data']['username']; ?>?')) banUser(<?php echo $template['data']['iduser']; ?>);" class="text-black text-decoration-none d-block p-1 px-3"><i class="bi bi-slash-circle"></i> Banna utente</a>
                                        </li>
                                    <?php
                                    } ?>
                                    <li>
                                        <a href="javascript:void(0)" onclick="editComment(<?php echo $template['data']['id']; ?>,this);" class="text-black text-decoration-none d-block p-1 px-3"><i class="bi bi-pencil"></i> Modifica commento</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="deleteComment(<?php echo $template['data']['id']; ?>);" class="text-danger text-decoration-none d-block p-1 px-3"><i class="bi bi-trash"></i> Elimina commento</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php
            }
            ?>
            <p class="text-wrap">
                <?php if ($template['data']['reply_to'] != "" && $template['data']['reply_to'] != $template['data']['username']) echo "<span class='fw-bold'>@{$template['data']['reply_to']}</span> ";

                $clength = ($template['version'] == "homepage") ? 100 : 250;
                if (strlen($template['data']['comment']) <= $clength) {
                ?>
                    <span class="message_text"><?php echo nl2br(htmlentities($template['data']['comment'])); ?></span>
                <?php
                } else {
                ?>
                    <span>
                        <?php echo nl2br(htmlentities(substr($template['data']['comment'], 0, $clength))); ?>
                        <?php if ($template['version'] == "homepage") {
                        ?>
                            …<a href="<?php echo ["notizie", "recensioni", "monografie", "anteprime"][$template['data']['type']]; ?>/<?php echo $template['data']['id']; ?>/<?php echo strtourl($template['data']['title']); ?>" class="spa text-decoration-none text-black fw-bold">Altro...</a>
                        <?php
                        } else {
                        ?>
                            …<a href="javascript:void(0)" onclick="$(this).parent().next().removeClass('d-none').prev().remove();" class="text-decoration-none text-black fw-bold">Altro...</a>
                        <?php
                        } ?>

                    </span>
                    <span class="message_text d-none">
                        <?php echo nl2br(htmlentities($template['data']['comment'])); ?>
                    </span>
                <?php
                }

                ?>
            </p>
            <?php if ($template['version'] != "homepage") { ?>
                <ul class="list-inline m-0 mt-1 small">
                    <?php
                    $commentLikes = "";
                    if (($lkey = array_search($template['data']['id'], array_column($commentsLikes, 'id'))) !== false)
                        $commentLikes = $commentsLikes[$lkey];
                    ?>
                    <li class="list-inline-item">
                        <a href="javascript:void(0)" onclick="likeComment(<?php echo $template['data']['id']; ?>,1,this);" class="text-black text-decoration-none d-inline-block">
                            <i class="bi bi-hand-thumbs-up<?php if ($commentLikes['liked']) echo "-fill"; ?>"></i> <span><?php echo 0 + $commentLikes['likes']; ?></span>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="javascript:void(0)" onclick="likeComment(<?php echo $template['data']['id']; ?>,0,this);" class="text-black text-decoration-none d-inline-block">
                            <i class="bi bi-hand-thumbs-down<?php if ($commentLikes['unliked']) echo "-fill"; ?>"></i> <span><?php echo 0 + $commentLikes['unlikes']; ?></span>
                        </a>
                    </li>

                    <li class="list-inline-item">
                        <a href="javascript:void(0)" onclick="replyComment(<?php echo $template['data']['id']; ?>,this);" class="text-black text-decoration-none d-inline-block">Rispondi</a>
                    </li>
                </ul>
            <?php } ?>
        </div>
        <!-- risposte ai commenti -->
        <div class="comments"></div>
        <?php
        if ($template['version'] != "homepage") {
            $qc = security_query("SELECT c.id, c.iduser, c.comment, DATE_FORMAT(c.date, '%H:%i %m/%d/%Y') as date, u.username from fr_posts_comments c inner join fr_users u on u.id = c.iduser where c.idpost = [i] and c.reply = {$template['data']['id']} order by c.date asc limit 5", array($post['id']));
            if (mysqli_num_rows($qc) > 0) {
                if ($_GET['comment'] != "") { //se è indicato un commento allora esplode tutte le risposte
                    $template['data'] = $qc->fetch_assoc();
                    include $webRoot . "/include/templates/comment.php";
                } else {
        ?>
                    <div onclick="loadComments(<?php echo $post['id']; ?>, <?php echo $template['data']['id']; ?>, this);" class="mt-2">
                        <a href="javascript:void(0)" class="text-black text-decoration-none"><i class="bi bi-reply flip"></i> Visualizza risposte</a>
                    </div>
        <?php
                }
            }
        }
        ?>
        <!-- risposte ai commenti -->
    </div>
</div>