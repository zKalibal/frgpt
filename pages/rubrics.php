<?php
if ($_SERVER['REDIRECT_STATUS'] != 404) {
    session_start();
    include_once ($webRoot = str_replace($_SERVER['PHP_SELF'], "", $_SERVER['SCRIPT_FILENAME'])) . "/php/functions.php";
    
    if ($_GET['id'] == "") {
        $metas = [
            "title" => "Rubriche",
            "description" => "Descrizione rubriche",
            "image" => "https://{$_SERVER['SERVER_NAME']}/img/benvenuti-su-finalround.webp"
        ];
    } else {
        $rubric = security_query("SELECT * from fr_rubrics where id = [i]", array($_GET['id']))->fetch_assoc();
        $metas = [
            "title" => "{$rubric['name']} - Rubrica",
            "description" => $rubric['description'],
            "image" => "https://{$_SERVER['SERVER_NAME']}/img/rubrics/{$rubric['id']}.webp"
        ];
    }

    //HEADER 
    setHeaders([
        "meta-title" => htmlentities($metas['title']),
        "meta-description" => htmlentities($metas['description']),
        "meta-url" => "{$_SERVER['SERVER_NAME']}/$uri",
        "meta-image" => $metas['image'],
    ]);

    /* TRACCIA SOLO SE E' UN LINK SPA ALTRIMENTI HA GIA' TRACCIATO LA INDEX.PHP, SE E' ARRIVATO FIN QUI VUOL DIRE CHE E' SAFE*/
    if ($_POST['spa']) security_uri($_POST['urlrewrite']);
    /* TRACCIA SOLO SE E' UN LINK SPA ALTRIMENTI HA GIA' TRACCIATO LA INDEX.PHP, SE E' ARRIVATO FIN QUI VUOL DIRE CHE E' SAFE*/

    if ($_GET['id'] == "") {
?>
        <div class="container-fluid container-lg py-4 px-3 px-lg-0">
            <div class="row">
                <?php
                $q = security_query("SELECT * from fr_rubrics order by name asc", []);
                while ($r = $q->fetch_assoc()) {
                ?>
                    <div class="col-12 col-xl-6 mb-xl-4">
                        <div>
                            <a class="spa d-block mb-2 bg-dark bg-opacity-10 rounded overflow-hidden" href="rubriche/<?php echo $r['id'] . "/" . strtourl($r['name']); ?>" rel="nofollow">
                                <picture class="ratio ratio-16x9 zoom portrait">
                                    <img loading="lazy" src="/img/rubrics/<?php echo $r['id']; ?>.webp">
                                </picture>
                            </a>
                            <a href="rubriche/<?php echo $r['id'] . "/" . strtourl($r['name']); ?>" class="spa text-decoration-none text-black d-block">
                                <h4 class="mb-2 fw-semibold m-0 fs-3 fst-italic"><?php echo $r['name']; ?></h4>
                            </a>
                            <p class="mb-2 "><?php echo $r['description']; ?></p>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    <?php
    } else {
        $_SESSION['postsLoaded'] = [];
        $loadPosts = "php/load_posts.php?rubric={$_GET['id']}";
    ?>
        <div class="container-fluid container-lg py-4 px-3 px-lg-0">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold"><?php echo $rubric['name']; ?></h2>
                <p><?php echo $rubric['description']; ?></p>
            </div>
            <div class="row posts"></div>
        </div>

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
<?php
    }
}
