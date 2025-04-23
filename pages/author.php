<?php
session_start();
include_once ($webRoot = str_replace($_SERVER['PHP_SELF'], "", $_SERVER['SCRIPT_FILENAME'])) . "/php/functions.php";

$author = security_query("SELECT * from fr_authors where id=[i]", [$_GET['id']])->fetch_assoc();

if ($author['id'] == "" || end(explode("/", explode("?", $uri)[0])) != strtourl($author['name'])) { //se non trova l'autore o il nome non coincide
    setHeaders(["redirect" => "/"]);
} else {
    //HEADER 
    setHeaders([
        "meta-title" => "{$author['name']} - FinalRound",
        "meta-description" => "Tutte le anteprime, recensioni, monografie e notizie scritte e pubblicate da {$author['name']} su FinalRound",
        "meta-url" => "{$_SERVER['SERVER_NAME']}/$uri",
        "meta-image" => "https://{$_SERVER['SERVER_NAME']}/img/authors/thumbs/{$author['id']}.webp",
    ]);

    /* TRACCIA SOLO SE E' UN LINK SPA ALTRIMENTI HA GIA' TRACCIATO LA INDEX.PHP, SE E' ARRIVATO FIN QUI VUOL DIRE CHE E' SAFE*/
    if ($_POST['spa']) security_uri($_POST['urlrewrite']);
    /* TRACCIA SOLO SE E' UN LINK SPA ALTRIMENTI HA GIA' TRACCIATO LA INDEX.PHP, SE E' ARRIVATO FIN QUI VUOL DIRE CHE E' SAFE*/
?>
    <div class="blur-backdrop overflow-hidden wow fadeIn">
        <div class="container py-4 px-3 px-lg-0">
            <center>
                <div class="ratio ratio-1x1 mb-2" style="width:150px;">
                    <div class="img rounded-circle bg-black bg-opacity-10" style="background-size:cover;background-position:center;background-image: url('/img/authors/thumbs/<?php echo $author['id']; ?>.webp?t=<?php echo filemtime("{$webRoot}/img/authors/thumbs/{$author['id']}.webp"); ?>');"></div>
                </div>
                <h2 class="fw-semibold mb-4"><?php echo $author['name']; ?></h2>
                <div class="col-12 col-lg-6 col-xl-4 text-start">
                    <p>
                        <?php echo ($author['description'] != "") ? $author['description'] : "Breve bio in arrivo, nel frattempo beccati questo Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."; ?>
                    </p>
                </div>
                <div class="hstack gap-2 mt-3">
                    <div class="ms-auto"></div>
                    <?php foreach (json_decode($author['socials'], true) as $key => $value) { ?>
                        <div><a target="_blank" href="<?php echo $value; ?>" class="text-decoration-none text-black"><i class="bi bi-<?php echo $key; ?>"></i></a></div>
                    <?php } ?>
                    <div><a href="mailto:<?php echo $author['email']; ?>" class="text-decoration-none text-black"><i class="bi bi-envelope"></i></a></div>
                    <div class="me-auto"></div>
                </div>
            </center>
            <?php
            $_SESSION['postsLoaded'] = [];
            $loadPosts = "php/load_posts.php?author={$author['id']}";
            ?>
            <div class="row posts mt-5"></div>
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
        </div>
    </div>
<?php } ?>