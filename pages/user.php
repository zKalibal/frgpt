<?php
session_start();
include_once ($webRoot = str_replace($_SERVER['PHP_SELF'], "", $_SERVER['SCRIPT_FILENAME'])) . "/php/functions.php";

$user = security_query("SELECT u.*, s.tier_id, s.tier from fr_users u left join fr_patreon_supporters s on s.email = u.email where u.id=[i]", [$_GET['id']])->fetch_assoc();

if ($user['id'] == "" || end(explode("/", explode("?", $uri)[0])) != strtourl($user['username'])) { //se non trova l'autore o il nome non coincide
    setHeaders(["redirect" => "/"]);
} else {
    //HEADER 
    setHeaders([
        "meta-title" => "{$user['username']} - FinalRound",
        "meta-robots" => "noindex"
    ]);

    /* TRACCIA SOLO SE E' UN LINK SPA ALTRIMENTI HA GIA' TRACCIATO LA INDEX.PHP, SE E' ARRIVATO FIN QUI VUOL DIRE CHE E' SAFE*/
    if ($_POST['spa']) security_uri($_POST['urlrewrite']);
    /* TRACCIA SOLO SE E' UN LINK SPA ALTRIMENTI HA GIA' TRACCIATO LA INDEX.PHP, SE E' ARRIVATO FIN QUI VUOL DIRE CHE E' SAFE*/
?>
    <div class="blur-backdrop overflow-hidden wow fadeIn">
        <div class="container py-4 px-3 px-lg-0">
            <center class="mb-4">
                <div class="ratio ratio-1x1 mb-2" style="width:150px;">
                    <div class="img rounded-circle bg-black bg-opacity-10" style="background-size:cover;background-position:center;background-image: url('/img/users/<?php echo $user['id']; ?>.webp?t=<?php echo filemtime("{$webRoot}/img/users/{$user['id']}.webp"); ?>');"></div>
                </div>
                <h2 class="fw-semibold"><?php echo getPatreonBadge($user['tier_id'], $user['tier']);?><span class="align-middle"><?php echo $user['username']; ?></span></h2>
                <?php if ($user['tier'] != "") { ?>
                    <h5 class="m-0"><?php echo $user['tier']; ?></h5>
                <?php } ?>
            </center>
            <h4 class="mb-4 fw-semibold m-0 fs-lg-5"><i class="bi bi-chat-right-dots me-1"></i> Commenti lasciati</h4>
            <?php
            $qc = security_query("SELECT p.id, p.title, p.type, c.comment, DATE_FORMAT(c.date, '%H:%i %m/%d/%Y') as date, u.id as iduser, u.username from fr_posts_comments c inner join fr_users u on u.id = c.iduser inner join fr_posts p on p.id = c.idpost where c.iduser = [i] and c.reply is null order by c.date desc", [$user['id']]);
            if (mysqli_num_rows($qc) > 0) {
            ?>
                <div class="owl-carousel comments">
                    <?php
                    while ($rc = $qc->fetch_assoc()) {
                        $template['version'] = "homepage";
                        $template['data'] = $rc;
                    ?>
                        <div>
                            <?php include $webRoot . "/include/templates/profileComment.php"; ?>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            <?php
            } else {
            ?>
                <p class="text-center bg-primary bg-opacity-10 p-2 rounded fw-bold">Nessun commento lasciato</p>
            <?php
            } ?>
            <hr class="my-4 bg-dark opacity-100 ">
            <h4 class="mb-4 fw-semibold m-0 fs-lg-5"><i class="bi bi-heart me-1"></i> Articoli preferiti</h4>
            <?php
            $_SESSION['postsLoaded'] = [];
            $loadPosts = "php/load_posts.php?user={$user['id']}";
            ?>
            <div class="row posts"></div>
            <script>
                var loadPost = "<?php echo $loadPosts; ?>";
                $(document).ready(function() {
                    loadPosts(loadPost);
                    gtag('js', new Date());
                    gtag('config', 'G-F862ZC7SF3');

                    $('.owl-carousel.comments').owlCarousel({
                        loop: false,
                        dots: true,
                        autoplay: true,
                        autoplayHoverPause: true,
                        items: 1,
                        responsiveClass: true,
                        margin: 15,
                        responsive: {
                            0: {
                                items: 1
                            },
                            768: {
                                items: 2
                            },
                            992: {
                                items: 4
                            }
                        }
                    });
                });

                function loadPosts(url) {
                    $.ajax({
                        async: false,
                        type: "GET",
                        url: url,
                        success: function(data, textStatus, request) {
                            if (data != "") {
                                $(".row.posts").append(data);
                            }
                        },
                        error: function(xhr, desc, err) {
                            console.log(err);
                        }
                    });
                }
            </script>
        </div>
    </div>
<?php } ?>