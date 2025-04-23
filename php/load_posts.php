<?php
session_start();
include_once ($webRoot = str_replace($_SERVER['PHP_SELF'], "", $_SERVER['SCRIPT_FILENAME'])) . "/php/functions.php";
$array = [];

if (count($_SESSION['postsLoaded']) > 0) $where = "and p.id not in (" . implode(",", $_SESSION['postsLoaded']) . ")";

if ($_GET['user'] != "") { //se è una richiesta di articoli preferiti dalla pagina utente
    array_push($array, $_GET['user']);
    $q = security_query("SELECT p.id, p.title, p.type, p.short_description, p.author_id, p.date, a.name as 'author_name', count(c.id) as comments from fr_posts p inner join fr_users_favorites uf on uf.idpost = p.id inner join fr_authors a on a.id = p.author_id left join fr_posts_comments c on c.idpost = p.id where p.status = 1 and uf.iduser = [i] $where group by p.id order by p.date desc limit 10", $array);
} else {
    if ($_GET['type'] != "") {
        $where .= " and p.type = [i]";
        array_push($array, $_GET['type']);
    }

    if ($_GET['platform'] != "") {
        $where .= " and FIND_IN_SET([i], p.platforms)";
        array_push($array, $_GET['platform']);
    }

    if ($_GET['author'] != "") {
        $where .= " and p.author_id = [i]";
        array_push($array, $_GET['author']);
    }

    if ($_GET['rubric'] != "") {
        //mostra le rubriche solo nella sezione rubriche
        $where .= " and p.rubric = [i]";
        array_push($array, $_GET['rubric']);
    } else if ($_GET['search'] == "" && $_GET['author'] == "") {
        //nasconde le rubriche nella home
        $where .= " and p.rubric is NULL";
    }

    if ($_GET['search'] != "") {
        $where .= " and (p.title like [s] or a.name like [s])";
        array_push($array, "%{$_GET['search']}%", "%{$_GET['search']}%");
    }

    $q = security_query("SELECT p.id, p.title, p.type, p.short_description, p.author_id, p.date, a.name as 'author_name', count(c.id) as comments from fr_posts p inner join fr_authors a on a.id = p.author_id left join fr_posts_comments c on c.idpost = p.id where p.status = 1 $where group by p.id order by p.date desc limit 10", $array);
}

if ((mysqli_num_rows($q)) > 0) {
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
    while ($r = $q->fetch_assoc()) {
        array_push($_SESSION['postsLoaded'], $r['id']);

?>
        <div class="col-12 col-xl-6 mb-xl-4 d-flex">
            <?php
            $template['data'] = $r;
            include $webRoot . "/include/templates/post_preview.php";
            ?>
        </div>
    <?php
    }
} else {
    ?>
    <div class="col-12">
        <p class="text-center bg-primary bg-opacity-10 p-2 rounded fw-bold">Non ci sono altri articoli da mostrare</p>
    </div>
<?php
}
if (mysqli_num_rows($q) >= 10) {
?>
    <div class="col-12">
        <a href="javascript:void(0)" onclick="loadPosts(loadPost);$(this).parent().remove();" class="text-center p-2 rounded fw-bold d-block text-decoration-none text-black border border-2 border-black">Mostra altri</a>
    </div>
<?php
}
?>