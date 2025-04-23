<?php
session_start();
include_once ($webRoot = str_replace($_SERVER['PHP_SELF'], "", $_SERVER['SCRIPT_FILENAME'])) . "/php/functions.php";

if ($_SESSION['user']['admin'] < 1) $status = "and status = 1";
$post = security_query("SELECT p.id, p.title,p.short_description,p.meta_title,p.meta_description,p.subscriptions,p.content,p.type,p.author_id,a.name as 'author_name', p.date, pl.name as ref_platform from fr_posts p inner join fr_authors a on a.id = p.author_id left join fr_platforms pl on pl.id = p.ref_platform where p.id = [i] and p.type = [i]  $status", array($_GET['id'], $_GET['type']))->fetch_assoc();

if ($post['id'] == "" || end(explode("/", explode("?", $uri)[0])) != strtourl($post['title'])) {
    setHeaders(["redirect" => "/"]);
} else {

    $img = "https://" . $_SERVER['SERVER_NAME'] . "/img/large/{$_GET['id']}/" . strtourl($post['title']) . ".webp?t=" . filemtime("$webRoot/img/posts/{$_GET['id']}.webp");
    $published_time = new DateTime($post['date']);
    $published_time = $published_time->format(DateTime::ATOM);

    //HEADER 
    setHeaders([
        "meta-title" => htmlentities($post['meta_title'] ?? $post['title']),
        "meta-description" => htmlentities($post['meta_description'] ?? $post['short_description']),
        "meta-url" => "{$_SERVER['SERVER_NAME']}/$uri",
        "meta-image" => $img,
        "meta-published_time" => $published_time,
        "meta-jsonld" => [
            "@context" => "https://schema.org",
            "@type" => "NewsArticle",
            "headline" => htmlentities($post['meta_title'] ?? $post['title']),
            "image" => [
                $img,
            ],
            "datePublished" => $published_time,
            "author" => [
                [
                    "@type" => "Person",
                    "name" => $post['author_name']
                ]
            ]
        ]
    ]);

    /* TRACCIA SOLO SE E' UN LINK SPA ALTRIMENTI HA GIA' TRACCIATO LA INDEX.PHP, SE E' ARRIVATO FIN QUI VUOL DIRE CHE E' SAFE*/
    if ($_POST['spa']) security_uri($_POST['urlrewrite'], $post['id']);
    /* TRACCIA SOLO SE E' UN LINK SPA ALTRIMENTI HA GIA' TRACCIATO LA INDEX.PHP, SE E' ARRIVATO FIN QUI VUOL DIRE CHE E' SAFE*/

    /* CONTROLLO SUB */
    $subRequired = [];
    if ($post['subscriptions'] != NULL && $_SESSION['user']['id'] != "") {

        $qs = security_query("SELECT id, name, channel_id from fr_channels where id in ({$post['subscriptions']})", array());
        while ($rs = $qs->fetch_assoc())
            if (twitch_GetSubInfo($rs['channel_id'])['tier'] == "") $subRequired[$rs['id']] = $rs['name'];
    }
    if ($post['subscriptions'] != NULL && $_SESSION['user']['id'] == "") {
?>
        <div class="container-fluid container-lg py-4 px-3 px-lg-0 text-center">
            <h4 class="mb-2 fw-semibold m-0 fs-3"><?php echo $post['title']; ?></h4>
            <p>Questo articolo è riservato agli abbonati Twitch, per leggerlo è necessario autenticarsi e associare il proprio account Twitch</p>
            <a href="https://id.twitch.tv/oauth2/authorize?client_id=6iw9pgqw0cz3a7hb9nvg1bpn7dlpit&amp;redirect_uri=https://roundtwo.altervista.org/php/twitch_login.php&amp;response_type=code&amp;scope=user:read:email+user:read:subscriptions" class="loader border-0 bg-twitch text-white p-3 text-center fw-bold text-uppercase text-decoration-none d-inline-block mt-4 lh-1 rounded"><i class="bi bi-twitch"></i> accedi con twitch</a>
        </div>
    <?php
    } else if (count($subRequired) > 0) {
    ?>
        <div class="container-fluid container-lg py-4 px-3 px-lg-0 text-center">
            <h4 class="mb-2 fw-semibold m-0 fs-3"><?php echo $post['title']; ?></h4>
            <p>Per leggere questo articolo è necessario associare il proprio account Twitch ed avere l'abbonamento attivo ai seguenti canali:</p>
            <div class="row justify-content-center">
                <?php foreach ($subRequired as $id => $channel) {
                ?>
                    <div class="col-12 col-md-4 col-lg-3 col-xl-2 wow fadeIn">
                        <img class="rounded-circle border border-2 border-light shadow-sm d-block m-auto mt-4" src="img/channels/<?php echo $id; ?>.webp" style="width: 150px!important;">
                        <label class="my-2 d-block"><b><?php echo $channel; ?></b></label>
                        <a href="https://twitch.tv/subs/<?php echo $channel; ?>" target="_blank" class="border-0 bg-twitch text-white p-2 text-center fw-bold text-uppercase text-decoration-none d-inline-block lh-1 rounded"><i class="bi bi-twitch"></i> Abbonati</a>
                    </div>
                <?php
                } ?>
            </div>
        </div>
    <?php
    }
    /* CONTROLLO SUB */ else {
        $content = json_decode($post['content'], true);
    ?>
        <div class="<?php if ($post['type'] == 0) echo "container p-0 border-lg-top border-2 border-black"; ?> wow fadeIn">
            <div class="row gx-5">
                <div class="post col">
                    <?php
                    foreach ($content['pages'] as $pi => $page) {
                    ?>
                        <?php /* ===============================================|PAGINA|=============================================== */ ?>
                        <div class="overflow-hidden p-0 <?php
                                                        echo "pi$pi" . " ";
                                                        /* classi */
                                                        echo implode(' ', $page['style']['display']) . " ";
                                                        if ($page['style']['container'] != "container-inner")
                                                            echo "{$page['style']['container']} ";

                                                        echo "{$page['style']['vertical-margin']} {$page['style']['background-color']} {$page['style']['background-opacity']}";
                                                        /* classi */
                                                        ?>">
                            <style>
                                <?php
                                if ($page['style']['bold-color'] != "")
                                    echo ".pi$pi b,.pi$pi strong,.pi$pi a{color:{$page['style']['bold-color']};}";
                                ?>
                            </style>
                            <div class=" <?php
                                            /* classi */
                                            if ($page['style']['container'] == "container-inner")
                                                echo "container p-0 ";

                                            if ($page['style']['background-color'] == "")
                                                echo "px-lg-0 ";
                                            else
                            if ($page['style']['container'] == "container-inner")
                                                echo "py-4 ";
                                            else
                                                echo "px-sm-4 py-4 ";

                                            /* classi */
                                            ?>">
                                <div class="row <?php
                                                echo $page['style']['justify-content'];
                                                echo ($page['style']['col-vertical-gap'] == "") ? " gy-4" : " {$page['style']['col-vertical-gap']}";
                                                if ($page['style']['col-border'] == "")
                                                    echo ($page['style']['col-horizontal-gap'] == "") ? " gx-4" : " {$page['style']['col-horizontal-gap']}";
                                                else
                                                    echo " gx-5";
                                                ?>">
                                    <?php
                                    foreach ($page['columns'] as $ci => $column) {
                                        switch ($page['style']['col-border']) {
                                            case "border-solid":
                                                $page['style']['col-border'] = "border-end border-2";
                                                break;
                                            case "border-dashed":
                                                $page['style']['col-border'] = "border-end border-2 border-dashed";
                                                break;
                                        }
                                    ?>
                                        <?php /* ===============================================|COLONNA|=============================================== */ ?>
                                        <div class="column d-flex <?php
                                                                    /* classi */
                                                                    echo
                                                                    implode(' ', $column['style']['display']) . " " .
                                                                        implode(' ', $column['sizes']) . " " .
                                                                        $page['style']['col-border'] . " " .
                                                                        $page['style']['col-border-color'] . " ";
                                                                    /* classi */
                                                                    ?>">
                                            <div class="d-flex w-100 <?php
                                                                        echo $column['style']['background-color'] . " " .
                                                                            $column['style']['background-opacity'] . " ";
                                                                        if ($column['style']['background-color'] != "") echo "py-4 px-3 p-sm-4 ";
                                                                        if ($column['style']['border-radius'] != "") echo "{$column['style']['border-radius']} overflow-hidden";
                                                                        ?>">
                                                <div class="row <?php
                                                                /* classi */
                                                                echo "{$column['style']['vertical-gap']} {$column['style']['horizontal-gap']} {$column['style']['vertical-align']} {$column['style']['horizontal-align']}";
                                                                /* classi */
                                                                ?>" style="min-width:100%;width: calc(100% + var(--bs-gutter-x))!important;">
                                                    <?php
                                                    foreach ($column['elements'] as $ei => $element) {
                                                    ?>
                                                        <?php /* ===============================================|ELEMENTO|=============================================== */ ?>
                                                        <div class="<?php
                                                                    /* classi */
                                                                    if ($column['style']['vertical-align'] == "align-content-stretch")
                                                                        echo "d-flex ";
                                                                    echo implode(' ', $element['style']['display']) . " " .
                                                                        implode(' ', $element['sizes']) . " ";
                                                                    /* classi */
                                                                    ?>">
                                                            <?php
                                                            if ($element['type'] == "text") {
                                                                /* TESTO */
                                                            ?>
                                                                <div class="<?php
                                                                            if ($element['style']['background-color'] != "" || $element['style']['border'] != "") {

                                                                                if ($element['style']['background-color'] == "")
                                                                                    echo "px-3 p-sm-4 ";
                                                                                else
                                                                                    echo "py-4 px-3 p-sm-4 ";

                                                                                if ($element['style']['border'] != "")
                                                                                    $element['style']['border'] = "border-sm border-2 {$element['style']['border-color']} ";
                                                                            } else
                                                                    if ($column['style']['background-color'] == "")
                                                                                echo "px-3 px-sm-0 ";
                                                                            if ($element['style']['border-radius'] != "") echo "{$element['style']['border-radius']} overflow-hidden ";
                                                                            echo "{$element['style']['initial-capital']} {$element['style']['border']} {$element['style']['font-family']} {$element['style']['color']} {$element['style']['text-opacity']} {$element['style']['background-color']} {$element['style']['background-opacity']} {$element['style']['font-size']} {$element['style']['font-weight']} " . implode(' ', $element['style']['text-align']) . " {$element['style']['line-height']}";
                                                                            ?> w-100 text-break ">
                                                                    <?php echo $element['content']; ?>
                                                                </div>
                                                                <?php
                                                                /* TESTO */
                                                            } else if ($element['type'] == "image") {
                                                                /* IMMAGINE */
                                                                $image = "/img/default/{$_GET['id']}-{$pi}-{$ci}-{$ei}/" . strtourl($post['title']) . ".webp?t=" . filemtime("$webRoot/img/posts/{$_GET['id']}_{$pi}_{$ci}_{$ei}.webp");
                                                                if ($column['style']['vertical-align'] == "align-content-stretch") {
                                                                ?>
                                                                    <div class="w-100 img <?php
                                                                                            if ($element['style']['border-radius'] != "") echo "{$element['style']['border-radius']} overflow-hidden ";
                                                                                            ?>" style="background-image:url(<?php echo $image; ?>)" <?php if ($element['style']['clickable']) echo "data-img-modal='{$image}'"; ?>>
                                                                        <img class='img-fluid' src='<?php echo $image; ?>'>
                                                                    </div>
                                                                <?php } else { ?>
                                                                    <div <?php if ($element['style']['clickable']) echo "data-img-modal='{$image}'"; ?>>
                                                                        <?php
                                                                        if ($element['style']['ratio'] == "default" || $element['style']['ratio'] == "")
                                                                            echo "<img class='img-fluid w-100' src='{$image}'>";
                                                                        else
                                                                            echo "<div class='img ratio ratio-{$element['style']['ratio']}' style='background-image:url({$image})'></div>";
                                                                        ?>
                                                                    </div>
                                                                <?php
                                                                }
                                                                /* IMMAGINE */
                                                            } else if ($element['type'] == "line") {
                                                                ?>
                                                                <div class="border-bottom border-2 <?php echo "{$element['style']['border-color']} {$element['style']['vertical-margin']}"; ?>"></div>
                                                            <?php
                                                            } else if ($element['type'] == "video") {
                                                            ?>
                                                                <div class="ratio ratio-16x9 <?php
                                                                                                if ($element['style']['border-radius'] != "") echo "{$element['style']['border-radius']} overflow-hidden ";
                                                                                                ?>">
                                                                    <iframe src="<?php echo str_replace("watch?v=", "embed/", $element['content']); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                                </div>
                                                            <?php
                                                            } else if ($element['type'] == "html") {
                                                                echo $element['content'];
                                                            }
                                                            ?>
                                                        </div>
                                                        <?php /* ===============================================|ELEMENTO|=============================================== */ ?>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <?php /* ===============================================|COLONNA|=============================================== */ ?>
                                </div>
                            </div>
                        </div>
                        <?php /* ===============================================|PAGINA|=============================================== */ ?>
                    <?php
                    }
                    ?>
                    <div class="px-3 px-lg-0 my-5 container">
                        <center>
                            <img class="rounded-circle border border-2 border-light shadow-sm" src="/img/authors/thumbs/<?php echo $post['author_id']; ?>.webp" style="width:100px!important;filter: grayscale(1);" />
                            <div class="mt-2">
                                <span class="lh-1 fs-6">A cura di</span>
                                <a href="<?php echo "staff/{$post['author_id']}/" . strtourl($post['author_name']); ?>" class="spa text-decoration-none text-reset d-block">
                                    <h6 class="m-0 text-truncate"><b><?php echo $post['author_name']; ?></b></h6>
                                </a>
                            </div>
                        </center>
                        <div class="row align-items-center justify-content-between mt-4 gx-4 gy-1">
                            <div class="col-auto">
                                <div class="vstack gap-2">
                                    <div>
                                        <p class="m-0"><b>Pubblicato il</b>: <?php echo date("d/m/Y", strtotime($post['date'])); ?></p>
                                    </div>
                                    <?php if ($post['ref_platform'] != "") { ?>
                                        <div>
                                            <p class="m-0"><b>Provato su</b>: <?php echo $post['ref_platform']; ?></p>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php if ($_SESSION['user']['id'] != "") {
                            ?>
                                <div class="col-auto">
                                    <div class="hstack gap-2">
                                        <div class="d-none d-lg-block"><b>Aggiungi ai preferiti</b>:</div>
                                        <div>
                                            <a href="javascript:void(0)" onclick="favoritePost(<?php echo $post['id']; ?>, this)" class="hstack text-black bg-primary bg-opacity-10 rounded p-1 gap-2 text-decoration-none">
                                                <span class="text-danger"><i class="bi <?php echo (security_query("SELECT id from fr_users_favorites where idpost = [i] and iduser = [i]", [$post['id'], $_SESSION['user']['id']])->fetch_assoc()['id'] != "") ? "bi-heart-fill" : "bi-heart"; ?>"></i></span>
                                                <span><?php echo mysqli_num_rows(security_query("SELECT id from fr_users_favorites where idpost = [i]", array($post['id']))); ?></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="container px-3 px-lg-0 py-4">
                        <div class="bg-black p-3 p-lg-4 rounded text-white">
                            <div class="row align-items-center g-4">
                                <div class="col-12 col-lg">
                                    <h5>Abbonati al Patreon di FinalRound</h5>
                                    <p class="m-0">
                                        Il tuo supporto serve per fare in modo che il sito resti senza pubblicità e garantisca un compenso etico ai collaboratori
                                    </p>
                                </div>
                                <div class="col-12 col-lg-auto text-end">
                                    <a href="https://www.patreon.com/FinalRound" target="_blank" class="d-inline-block border-0 bg-white p-2 lh-1 text-black text-decoration-none fw-bold text-center rounded">Abbonati</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border-top border-2 border-dark mt-3 px-3 px-lg-0 py-4 container">
                        <center>
                            <i class="bi bi-chat-square-dots display-6"></i>
                            <?php $ncomm = mysqli_num_rows(security_query("SELECT id from fr_posts_comments where idpost = [i]", array($post['id']))); ?>
                            <h4 class="mb-4 mt-1 fw-semibold m-0 fs-5 lh-1"> <?php echo ($ncomm == 1) ? "$ncomm commento" : "$ncomm commenti"; ?></h4>
                        </center>
                        <form id="comment" class="m-0" onsubmit="return false;">
                            <div class="row gx-2 gx-lg-3">
                                <div class="d-none d-lg-inline  col-auto">
                                    <div class="mb-2 img user position-relative ratio ratio-1x1 rounded-circle border border-2 border-light shadow-sm" style="width:45px; <?php if (file_exists($webRoot . '/img/users/' .  $_SESSION['user']['id'] . '.webp')) { ?> background-image: url('/img/users/<?php echo  $_SESSION['user']['id']; ?>.webp');<?php } ?>"></div>
                                </div>
                                <div class="col">
                                    <div class="form-floating">
                                        <textarea name="comment" maxlength="8000" class="form-control bg-transparent border-black border-2 no-outline" placeholder="<?php echo ($_SESSION['user']['id'] != "") ? "Lascia un commento" : "Registrati o effettua l'accesso per commentare"; ?>" style="height: 100px" required <?php if ($_SESSION['user']['id'] == "") echo "disabled"; ?>></textarea>
                                        <label><?php echo ($_SESSION['user']['id'] != "") ? "Lascia un commento" : "Registrati o effettua l'accesso per commentare"; ?></label>
                                    </div>
                                </div>
                            </div>
                            <?php if ($_SESSION['user']['id'] != "") { ?>
                                <div class="text-end mt-3">
                                    <button type="submit" onclick="if ($(this).closest('form')[0].reportValidity()) postComment(<?php echo $post['id']; ?>,$(this).closest('form'));" class="border-0 bg-black p-2 lh-1 text-white text-decoration-none fw-bold text-center rounded"><i class="bi bi-send small"></i> Invia</button>
                                </div>
                            <?php } ?>
                        </form>
                        <!-- COMMENTI POST -->
                        <div class="comments">
                            <?php
                            $_SESSION['commentsLoaded'] = [];
                            include $webRoot . "/php/load_comments.php";
                            ?>
                        </div>
                        <?php if ($_GET['comment']!="" || mysqli_num_rows(security_query("SELECT id from fr_posts_comments where idpost = [i] and reply is null", array($post['id']))) > 10) { ?>
                            <a href="javascript:void(0)" onclick="loadComments(<?php echo $post['id']; ?>, '', this);" class="text-black text-decoration-none d-block mt-3 text-center">Visualizza altri commenti</a>
                        <?php } ?>
                        <script type="text/javascript" src="js/post.js?v=3"></script>
                        <!-- COMMENTI POST -->
                    </div>
                </div>
                <?php if ($post['type'] == 0) { ?>
                    <div class="col-12 col-lg-3 pt-4" style="border-left:2px solid #000;">
                        <div class="px-3 px-lg-0">
                            <?php
                            $qs = security_query("SELECT p.*, a.id as 'author_id', a.name as 'author_name', count(c.id) as comments from fr_posts p inner join fr_authors a on a.id = p.author_id left join fr_posts_comments c on c.idpost = p.id where p.status = 1 group by p.id order by p.date desc limit 4", array());
                            /* TEMPLATE */
                            $template =
                                [
                                    "elements" => [
                                        "image" =>
                                        [
                                            "size" => "large",
                                            "labels" => "",
                                            "ratio" => "ratio-4x3",
                                            "custom_classes" => "zoom portrait",
                                            "loading" => "lazy"
                                        ],
                                        "metas" => "", "title" => "",  "author" => "", "hr" => ""
                                    ]
                                ];
                            /* TEMPLATE */
                            while ($rs = $qs->fetch_assoc()) {
                            ?>
                                <div class="mb-xl-4">
                                    <?php
                                    $template['data'] = $rs;
                                    include $webRoot . "/include/templates/post_preview.php";
                                    ?>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                gtag('js', new Date());
                gtag('config', 'G-F862ZC7SF3');
            });
        </script>
<?php
    }
}
?>