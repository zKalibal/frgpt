<?php
if ($_SERVER['REDIRECT_STATUS'] != 404) {
    session_start();
    include_once ($webRoot = str_replace($_SERVER['PHP_SELF'], "", $_SERVER['SCRIPT_FILENAME'])) . "/php/functions.php";

    /* TRACCIA SOLO SE E' UN LINK SPA ALTRIMENTI HA GIA' TRACCIATO LA INDEX.PHP, SE E' ARRIVATO FIN QUI VUOL DIRE CHE E' SAFE*/
    if ($_POST['spa']) security_uri($_POST['urlrewrite']);
    /* TRACCIA SOLO SE E' UN LINK SPA ALTRIMENTI HA GIA' TRACCIATO LA INDEX.PHP, SE E' ARRIVATO FIN QUI VUOL DIRE CHE E' SAFE*/

    if ($_GET['type'] == "")
        $type = "default";
    else {
        if (!is_numeric($_GET['type'])) $_GET['type'] = ["notizie" => 0, "recensioni" => 1, "monografie" => 2, "anteprime" => 3][$_GET['type']];
        $type = $_GET['type'];
    }

    if ($_GET['platform'] != "") {
        $platform = security_query("select id,name,slug from fr_platforms where slug = [s]", array($_GET['platform']))->fetch_assoc();
        $platform['name'] = " " . $platform['name'];
    }

    $metas = [
        "default" => [
            "title" => ($_GET['platform'] == "") ? "FinalRound" : trim($platform['name']),
            "description" => "FinalRound è un sito di informazione, critica e approfondimento dedicato al mondo dei videogame. Non troverete notizie clickbait, ma recensioni e opinioni trasparenti, sui giochi che ci appassionano."
        ],
        [
            "title" => "Notizie" . $platform['name'],
            "description" => "Non ci piace raccontare l’attualità con i rumor e le notizie di consumo. Qui commentiamo le ultime news con un taglio più deciso e personale, per inquadrare al meglio le novità del mercato."
        ],
        [
            "title" => "Recensioni" . $platform['name'],
            "description" => "Review dirette, comunicative, trasparenti, senza l’urgenza di dare un voto. Se volete leggere le opinioni della nostra redazione, qui trovate le recensioni dei giochi del momento (e non solo)."
        ],
        [
            "title" => "Monografie" . $platform['name'],
            "description" => "Approfondimenti, monografie, speciali di carattere storico e artistico. Se volete analizzare nel dettaglio i vostri videogiochi preferiti, questa è la sezione che fa per voi."
        ],
        [
            "title" => "Anteprime" . $platform['name'],
            "description" => "I nostri Most Wanted, i videogiochi più attesi, e le preview esclusive dagli eventi. In questa sezione vi diamo le nostre impressioni preliminari sui giochi che arriveranno nei prossimi mesi."
        ],
    ];

    //HEADER 
    setHeaders([
        "meta-title" => htmlentities($metas[$type]['title']),
        "meta-description" => htmlentities($metas[$type]['description']),
        "meta-url" => "{$_SERVER['SERVER_NAME']}/$uri",
        "meta-image" => "https://{$_SERVER['SERVER_NAME']}/img/benvenuti-su-finalround.webp",
    ]);
?>

    <?php if ($_GET['type'] == "" && $_GET['platform'] == "" && $_GET['q'] == "") {
        $_SESSION['postsLoaded'] = [];
        $loadPosts = "php/load_posts.php";
    ?>
        <div class="container-fluid container-lg py-4 px-3 px-lg-0">
            <div class="row">
                <div class="order-2 order-lg-1 col-12 col-md-4 col-lg-3">
                    <!-- ANTEPRIME -->
                    <?php
                    /* TEMPLATE */
                    $template =
                        [
                            "elements" => [
                                "image" =>
                                [
                                    "size" => "large",
                                    "labels" => "",
                                    "ratio" => "ratio-4x3",
                                    "custom_classes" => "zoom portrait"
                                ],
                                "title" =>
                                [
                                    "custom_classes" => "fs-lg-5"
                                ],
                                "author" => "",
                                "description" => [
                                    "custom_classes" => "text-truncate"
                                ]
                            ]
                        ];
                    /* TEMPLATE */

                    $q = security_query("SELECT p.id, p.title, p.type, p.short_description, p.author_id, p.date, p.rubric, a.name as 'author_name', count(c.id) as comments FROM `fr_posts` p inner join fr_authors a on a.id = p.author_id left join fr_posts_comments c on c.idpost = p.id JOIN ( SELECT rubric, MAX(date) AS max_date FROM `fr_posts` WHERE rubric is not null GROUP BY rubric ) subquery ON (p.rubric = subquery.rubric AND p.date = subquery.max_date) or p.rubric is null WHERE p.status = 1 and (p.type = 1 or p.type = 0) GROUP BY p.id order by p.type asc, p.date desc limit 3", array());
                    while ($r = $q->fetch_assoc()) {
                        array_push($_SESSION['postsLoaded'], $r['id']);
                        $template['version'] = "homepage";
                        $template['data'] = $r;
                        include $webRoot . "/include/templates/post_preview.php";
                        unset($template['elements']['image']); //PROVVISORIO

                    ?>
                        <hr class="my-3 bg-dark opacity-100 ms-n3 me-n3 mx-md-0">
                    <?php
                    }
                    ?>
                    <!-- ANTEPRIME -->

                    <!-- PODCAST -->
                    <h4 class="mb-2 fw-semibold m-0 fs-lg-5"><i class="bi bi-broadcast-pin me-1"></i> Podcast: Gong</h4>
                    <iframe class="mb-4" style="border-radius:12px" src="https://open.spotify.com/embed/show/3KHH8FiN2cRYbDskoLZTA3?utm_source=generator&theme=0" width="100%" height="352" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>
                    <!-- PODCAST -->

                    <!-- COMMENTI RECENTI -->
                    <h4 class="mb-2 fw-semibold m-0 fs-lg-5"><i class="bi bi-chat-right-dots me-1"></i> Commenti recenti</h4>
                    <div id="comments" class="mb-4">
                        <?php
                        $qc = security_query("SELECT p.id, p.title, p.type, c.comment, DATE_FORMAT(c.date, '%H:%i %m/%d/%Y') as date, u.id as iduser, u.username, s.tier_id, s.tier from fr_posts_comments c inner join fr_users u on u.id = c.iduser inner join fr_posts p on p.id = c.idpost left join fr_patreon_supporters s on s.email = u.email where c.reply is null and c.pinnedby is not NULL order by c.date desc limit 5", array());
                        while ($rc = $qc->fetch_assoc()) {
                            $template['version'] = "homepage";
                            $template['data'] = $rc;
                            include $webRoot . "/include/templates/comment.php";
                        }
                        ?>
                    </div>
                    <!-- COMMENTI RECENTI -->

                    <?php
                    // NON VOLUTA, ma non si sa mai. 
                    //$qs = security_query("SELECT u.username, u.id as iduser, s.* from fr_patreon_supporters s left join fr_users u on u.email = s.email order by s.campaign_lifetime_support_cents desc limit 5", []);
                    if (false && mysqli_num_rows($qs) > 0) {
                    ?>
                        <!-- TOP SUPPORTER -->
                        <h4 class="mb-4 fw-semibold m-0 fs-lg-5"><i class="bi bi-trophy me-1"></i> Top supporters</h4>
                        <div class="vstack gap-3 mb-4">
                            <?php
                            $supportPos = 1;
                            while ($rs = $qs->fetch_assoc()) {
                                if ($rs['iduser'] != "") {
                            ?>
                                    <div>
                                        <a href="<?php echo "user/{$rs['iduser']}/" . strtourl($rs['username']); ?>" role="button" class="spa d-flex text-decoration-none text-black hstack gap-0">
                                            <?php if (file_exists($webRoot . '/img/users/' .  $rs['iduser'] . '.webp')) { ?>
                                                <div>
                                                    <div class="ratio ratio-1x1" style="width:45px">
                                                        <div class="img rounded-circle border border-2 border-light shadow-sm" style="background-size:cover;background-position:center;background-image: url('/img/users/<?php echo  $rs['iduser']; ?>.webp');"></div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="p-2 me-auto"><?php echo getPatreonBadge($rs['tier_id'], $rs['tier']); ?><b><?php echo $rs['username']; ?></b></div>
                                            <div>
                                                <span class="fs-5 opacity-25"><b><?php echo $supportPos; ?></b>°</span>
                                            </div>
                                        </a>
                                    </div>

                                <?php
                                } else {
                                ?>
                                    <div>
                                        <div class="hstack gap-0">
                                            <div class="me-auto"><?php echo getPatreonBadge($rs['tier_id'], $rs['tier']); ?><b><?php echo $rs['full_name']; ?></b></div>
                                            <div>
                                                <span class="fs-5 opacity-25"><b><?php echo $supportPos; ?></b>°</span>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                $supportPos++;
                                ?>
                                <div>
                                    <hr class="my-0 bg-dark opacity-100 ms-n3 me-n3 mx-md-0" />
                                </div>
                            <?php
                            }
                            ?>
                            <div>
                                <a href="supporters" class="spa p-1 text-center text-decoration-none text-black d-block rounded bg-primary bg-opacity-10">Vedi tutti</a>
                            </div>
                        </div>
                        <!-- TOP SUPPORTER -->
                    <?php } ?>
                </div>
                <div class="order-3 order-lg-2 col-12 col-md-8 col-lg-6">

                    <!-- POST IN EVIDENZA -->
                    <div class="d-none d-lg-block">
                        <div class="owl-carousel featured">
                            <?php
                            /* TEMPLATE */
                            $template =
                                [
                                    "elements" => [
                                        "image" =>
                                        [
                                            "size" => "large",
                                            "labels" => "",
                                            "ratio" => "ratio-4x3 ratio-lg-16x9",
                                            "custom_classes" => "zoom landscape"
                                        ],
                                        "title" =>
                                        [
                                            "custom_classes" => "fs-3"
                                        ],
                                        "metas" => "", "description" => "", "author" => ""
                                    ]
                                ];
                            /* TEMPLATE */
                            $q = security_query("SELECT p.id, p.title, p.type, p.short_description, p.author_id, p.date, a.name as 'author_name', count(c.id) as comments from fr_posts p inner join fr_authors a on a.id = p.author_id left join fr_posts_comments c on c.idpost = p.id where p.status = 1 and p.featured = 1 group by p.id order by p.date desc limit 10", array());
                            while ($r = $q->fetch_assoc()) {
                            ?>
                                <?php
                                $template['data'] = $r;
                                include $webRoot . "/include/templates/post_preview.php";
                                ?>
                            <?php } ?>
                        </div>
                    </div>
                    <!-- POST IN EVIDENZA -->

                    <hr class="d-none d-lg-block my-3 bg-dark opacity-100 ">

                    <!-- RECENSIONI -->
                    <?php
                    $q = security_query("SELECT p.id, p.title, p.type, p.short_description, p.author_id, p.date, a.name as 'author_name', count(c.id) as comments from fr_posts p inner join fr_authors a on a.id = p.author_id left join fr_posts_comments c on c.idpost = p.id where p.status = 1 and p.type = 1 group by p.id order by p.date desc limit 2", array());
                    if ((mysqli_num_rows($q)) > 0) {
                    ?>
                        <div class="row">
                            <?php
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
                                        "metas" => "", "title" => "", "description" => "", "author" => "", "hr" => ""
                                    ]
                                ];
                            /* TEMPLATE */
                            while ($r = $q->fetch_assoc()) {
                                array_push($_SESSION['postsLoaded'], $r['id']);

                            ?>
                                <div class="col-12 col-xl-6 d-flex">
                                    <?php
                                    $template['data'] = $r;
                                    include $webRoot . "/include/templates/post_preview.php";
                                    ?>
                                </div>
                            <?php
                            }
                            ?>
                            <div class="d-none d-xl-flex col-12">
                                <hr class="w-100 my-3 bg-dark opacity-100 ms-n3 me-n3 mx-md-0">
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                    <!-- RECENSIONI -->

                    <!-- TUTTE LE NOTIZIE -->
                    <div class="row posts"></div>
                    <!-- TUTTE LE NOTIZIE -->
                </div>
                <div class="order-1 order-lg-3 col-12 col-md-8 col-lg-3">

                    <!-- POST IN EVIDENZA MOBILE -->
                    <div class="d-lg-none">
                        <div class="owl-carousel featured">
                            <?php
                            /* TEMPLATE */
                            $template =
                                [
                                    "elements" => [
                                        "image" =>
                                        [
                                            "size" => "large",
                                            "labels" => "",
                                            "ratio" => "ratio-4x3 ratio-lg-16x9",
                                            "custom_classes" => "zoom portrait landscape-lg"
                                        ],
                                        "title" =>
                                        [
                                            "custom_classes" => "fs-3"
                                        ],
                                        "metas" => "", "description" => "", "author" => ""
                                    ]
                                ];
                            /* TEMPLATE */
                            $q = security_query("SELECT p.id, p.title, p.type, p.short_description, p.author_id, p.date, a.name as 'author_name', count(c.id) as comments from fr_posts p inner join fr_authors a on a.id = p.author_id left join fr_posts_comments c on c.idpost = p.id where p.status = 1 and p.featured = 1 group by p.id order by p.date desc limit 10", array());
                            while ($r = $q->fetch_assoc()) {
                            ?>
                                <?php
                                $template['data'] = $r;
                                include $webRoot . "/include/templates/post_preview.php";
                                ?>
                            <?php } ?>
                        </div>
                        <hr class="my-3 bg-dark opacity-100 ms-n3 me-n3 mx-md-0">
                    </div>
                    <!-- POST IN EVIDENZA MOBILE -->

                    <!-- MONOGRAFIE -->
                    <?php
                    /* TEMPLATE */
                    $template =
                        [
                            "elements" => [
                                "image" =>
                                [
                                    "size" => "large",
                                    "labels" => "",
                                    "ratio" => "ratio-4x3 ratio-lg-1x1_5",
                                    "custom_classes" => "zoom portrait"
                                ],
                                "title" =>
                                [
                                    "custom_classes" => "fs-lg-5"
                                ],
                                "author" => ""
                            ]
                        ];
                    /* TEMPLATE */
                    $q = security_query("SELECT p.id, p.title, p.type, p.short_description, p.author_id, p.date, a.name as 'author_name', count(c.id) as comments from fr_posts p inner join fr_authors a on a.id = p.author_id left join fr_posts_comments c on c.idpost = p.id where p.status = 1 and p.type = 2 group by p.id order by p.date desc limit 5", array());
                    while ($r = $q->fetch_assoc()) {
                        array_push($_SESSION['postsLoaded'], $r['id']);
                        $template['data'] = $r;
                        include $webRoot . "/include/templates/post_preview.php";

                    ?>
                        <hr class="my-3 bg-dark opacity-100 ms-n3 me-n3 mx-md-0">
                    <?php
                    }
                    ?>
                    <!-- MONOGRAFIE -->

                </div>

            </div>
        </div>
        <script>
            $('.owl-carousel.featured').owlCarousel({
                loop: true,
                dots: true,
                autoplay: true,
                autoplayHoverPause: true,
                items: 1,
                responsiveClass: true
            });
        </script>
    <?php } else {
        $_SESSION['postsLoaded'] = [];
        $loadPosts = "php/load_posts.php?type={$_GET['type']}&platform={$platform['id']}&search={$_GET['q']}";
    ?>
        <div class="container-fluid container-lg py-4 px-3 px-lg-0">
            <div class="row posts"></div>
        </div>
    <?php } ?>

    <script>
        var loadPost = "<?php echo $loadPosts; ?>";
        $(document).ready(function() {
            loadPosts(loadPost);
            gtag('js', new Date());
            gtag('config', 'G-F862ZC7SF3');
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
<?php } ?>