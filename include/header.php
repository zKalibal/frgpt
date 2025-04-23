<div class="container-fluid container-lg blur-backdrop my-3 mb-0 pb-3 text-center  border-bottom border-2 border-black">
    <div class="row align-items-center justify-content-center">
        <div class="col border-end border-2 border-black">
            <!--
            <div class="p-3">
                <img class="img-fluid" src="https://federicstore.it/wp-content/themes/federicstore/assets/img/federic-logo.gif" title="Federic Store" style="width: 200px;">
            </div>
            -->
        </div>
        <div class="col-6 text-center">
            <a href="/"><img class=" img-fluid" src="img/logo.svg?v=1" style="width: 300px;margin: auto;"></a>
        </div>
        <div class="col text-end">
            <?php if ($_SESSION['user']['id'] != "") { ?>
                <div class="dropdown user-nav text-end">
                    <a href="#" role="button" class="d-inline-flex ms-auto text-decoration-none text-black hstack gap-1 bg-primary bg-opacity-10 p-1 pe-lg-3 rounded-pill small" data-bs-toggle="dropdown">
                        <div>
                            <div class="ratio ratio-1x1" style="width:35px">
                                <div class="img rounded-circle bg-black bg-opacity-10 border border-2 border-black" style="background-size:cover;background-position:center;<?php if (file_exists($webRoot . '/img/users/' . $_SESSION['user']['id'] . '.webp')) { ?> background-image: url('/img/users/<?php echo $_SESSION['user']['id']; ?>.webp?t=<?php echo filemtime($webRoot . '/img/users/' . $_SESSION['user']['id'] . '.webp'); ?>');<?php } ?>"></div>
                                <?php if (security_query("SELECT * from fr_users_notifications where iduser = {$_SESSION['user']['id']} and seen = 0", [])->num_rows > 0) {
                                ?>
                                    <span class="new_notifications mt-1 ms-1 position-absolute top-0 start-0 translate-middle bg-danger border border-light rounded-circle" style="width:15px;height:15px;">
                                        <span class="visually-hidden">New alerts</span>
                                    </span>
                                <?php
                                } ?>
                            </div>
                        </div>
                        <div class="d-none d-lg-block"><b><?php echo $_SESSION['user']['username']; ?></b></div>
                        <div class="d-none d-lg-block"><i class="bi bi-chevron-down small"></i></div>

                    </a>
                    <ul class="dropdown-menu dropdown-menu-end overflow-hidden p-0 pt-2 shadow fw-bold text-nowrap" style="z-index: 9999;max-width: 300px;">
                        <li>
                            <a href="<?php echo "user/{$_SESSION['user']['id']}/" . strtourl($_SESSION['user']['username']); ?>" class="spa text-black text-decoration-none d-block p-1 px-3"><i class="bi bi-person-workspace me-2"></i> Profilo pubblico</a>
                        </li>
                        <li>
                            <a href="account" class="spa text-black text-decoration-none d-block p-1 px-3"><i class="bi bi-gear me-2"></i> Account</a>
                        </li>
                        <li>
                            <a href="php/logout.php" class="text-black text-decoration-none d-block p-1 px-3"><i class="bi bi-power me-2"></i> Disconnetti</a>
                        </li>
                        <!-- notifiche -->
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <h6 class="dropdown-header">Ultime notifiche</h6>
                            <div class="notifications vstack gap-2 p-3 pt-0"></div>
                        </li>
                    </ul>
                </div>
            <?php } ?>
            <!--
            <div class="hstack gap-2 my-3 fs-4">
                <div class="ms-auto"></div>
                <div><a target="_blank" href="https://www.twitch.tv/roundtwotwitch" class="text-decoration-none text-black"><i class="bi bi-twitch"></i></a></div>
                <div><a target="_blank" href="https://www.instagram.com/foxxett/" class="text-decoration-none text-black"><i class="bi bi-instagram"></i></a></div>
                <div><a target="_blank" href="https://www.youtube.com/channel/UC7ChYfW_quejzELkkfQdSmg" class="text-decoration-none text-black"><i class="bi bi-youtube"></i></a></div>
                <div class="me-auto"></div>
            </div>
            -->
        </div>
    </div>
</div>
<nav class="sticky-top bg-old blur-backdrop">
    <div class="container-fluid container-lg p-0 border-bottom border-2 border-black position-relative">
        <div class="position-absolute h-100 end-0 top-0" style="z-index: 10;background:-webkit-linear-gradient(0deg,rgba(48,49,52,0),#fffff6);width: 24px;"></div>
        <div class="hscroll">
            <div>
                <table class="table table-borderless text-nowrap text-center m-0 fw-black" style="min-width: auto;width: auto;margin: auto!important;">
                    <tbody>
                        <tr class="align-middle">
                            <td class="p-0">
                                <a href="/" class="p-3 lh-1 d-block spa text-black text-decoration-none <?php if ($_SERVER['REQUEST_URI'] == "/") echo 'active'; ?>">
                                    PRIMA PAGINA
                                </a>
                            </td>
                            <td class="px-0">
                                <div class="vr"></div>
                            </td>
                            <td class="p-0">
                                <a href="anteprime" class="p-3 lh-1 d-block spa type text-black text-decoration-none <?php if (strpos($_SERVER['REQUEST_URI'], "/anteprime") !== false) echo 'active'; ?>">
                                    ANTEPRIME
                                </a>
                            </td>
                            <td class="p-0">
                                <div class="vr"></div>
                            </td>
                            <td class="p-0">
                                <a href="recensioni" class="p-3 lh-1 d-block spa type text-black text-decoration-none <?php if (strpos($_SERVER['REQUEST_URI'], "/recensioni") !== false)  echo 'active'; ?>">
                                    RECENSIONI
                                </a>
                            </td>
                            <td class="px-0">
                                <div class="vr"></div>
                            </td>
                            <td class="p-0">
                                <a href="monografie" class="p-3 lh-1 d-block spa type text-black text-decoration-none <?php if (strpos($_SERVER['REQUEST_URI'], "/monografie") !== false)  echo 'active'; ?>">
                                    MONOGRAFIE
                                </a>
                            </td>
                            <td class="px-0">
                                <div class="vr"></div>
                            </td>
                            <td class="p-0">
                                <a href="notizie" class="p-3 lh-1 d-block spa type text-black text-decoration-none <?php if (strpos($_SERVER['REQUEST_URI'], "/notizie") !== false)  echo 'active'; ?>">
                                    ATTUALITÀ
                                </a>
                            </td>
                            <td class="px-0">
                                <div class="vr"></div>
                            </td>
                            <td class="p-0">
                                <a href="rubriche" class="p-3 lh-1 d-block spa type text-black text-decoration-none <?php if (strpos($_SERVER['REQUEST_URI'], "/rubriche") !== false)  echo 'active'; ?>">
                                    RUBRICHE
                                </a>
                            </td>
                            <td class="px-0">
                                <div class="vr"></div>
                            </td>
                            <?php if ($_SESSION['user']['id'] == "") { ?>
                                <td class="p-0">
                                    <a href="login" class="p-3 lh-1 d-block spa text-black text-decoration-none <?php if ($_SERVER['REQUEST_URI'] == "/login") echo 'active'; ?>">
                                        ACCEDI
                                    </a>
                                </td>
                            <?php } ?>
                            <?php if ($_SESSION['user']['admin'] > 0) { ?>
                                <td class="px-0">
                                    <div class="vr"></div>
                                </td>
                                <td class="p-0">
                                    <a href="?page=admin/manage_posts.php" class="spa p-3 lh-1 d-block text-black text-decoration-none <?php if ($_SERVER['REQUEST_URI'] == "/?page=admin/manage_posts.php") echo 'active'; ?>">
                                        GESTIONE
                                    </a>
                                </td>
                            <?php } else {
                            ?>
                                <!--
                                <td class="px-0">
                                    <div class="vr"></div>
                                </td>
                                <td class="p-0">
                                    <a href="https://twitch.tv/roundtwotwitch" target="_blank" class="p-3 lh-1 d-block text-black text-decoration-none">
                                        ABBONATI
                                    </a>
                                </td>
                                -->
                            <?php
                            } ?>
                            <td class="px-0">
                                <div class="vr"></div>
                            </td>
                            <td class="px-3 py-0">
                                <!-- SEARCH -->
                                <div class="input-group" style="min-width:200px;">
                                    <span class="input-group-text pe-0 bg-primary bg-opacity-10 border-0 rounded-0"><i class="bi bi-search"></i></span>
                                    <input type="text" onkeyup="search(this);" value="<?php echo $_GET['q']; ?>" placeholder="Cerca articolo, autore.." class="py-1 m-0 form-control border-0 bg-primary bg-opacity-10 rounded-0 no-outline">
                                </div>
                                <script>
                                    var searchTyping = null;

                                    function search(s) {
                                        $(s).prev().find("i").replaceWith('<div class="spinner-border spinner-border-sm" role="status">');
                                        clearTimeout(searchTyping);
                                        searchTyping = setTimeout(
                                            function() {
                                                loadpage(s.value != '' ? 'cerca?q=' + s.value : '/', "#container", '', 'push');
                                                $(s).prev().html('<i class="bi bi-search"></i>');
                                            }, 400);
                                    }
                                </script>
                                <!-- SEARCH -->
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</nav>
<nav class="platforms">
    <div class="container-fluid container-lg py-1 px-0 blur-backdrop ">
        <div class="hscroll">
            <div>
                <table class="table table-sm table-borderless text-nowrap text-center m-0">
                    <tbody>
                        <tr class="align-middle">
                            <td class="p-0">
                                <a href="*" class="spa platform p-1 ps-3 px-lg-2 text-black text-decoration-none">Qualsiasi</a>
                            </td>
                            <?php
                            $ip = 0;
                            $qp = security_query("SELECT * from fr_platforms where priority is not null order by priority asc", array())->fetch_all(MYSQLI_ASSOC);
                            foreach ($qp as $rp) {
                                $ip++;
                            ?>
                                <td>
                                    <div class="vr"></div>
                                </td>
                                <td class="p-0">
                                    <a href="<?php echo $rp['slug']; ?>" class="spa platform <?php echo (count($qp) == $ip) ? "p-1 pe-3 px-lg-2" : "p-1 px-2"; ?> rounded-pill text-black text-decoration-none <?php if (strpos($_SERVER['REQUEST_URI'], $rp['slug']) !== false) echo "active"; ?>"><?php echo $rp['name']; ?></a>
                                </td>
                            <?php

                            }
                            ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</nav>