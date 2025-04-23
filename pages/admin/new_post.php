<?php
session_start();
include_once ($webRoot = str_replace($_SERVER['PHP_SELF'], "", $_SERVER['SCRIPT_FILENAME'])) . "/php/functions.php";
if ($_SESSION['user']['admin'] != 1) { //se non è admin
    setHeaders(["redirect" => "/"]);
} else {
    
    //HEADER 
    setHeaders([
        "meta-title" => "Nuovo post",
        "meta-robots" => "noindex"
    ]);

    if ($_GET['id'] != "") {
        $post = security_query("SELECT * from fr_posts where id = {$_GET['id']}", [])->fetch_assoc();
        $_SESSION['new_post'][$_GET['id']] = json_decode($post['content'], true);
    } else {
        $_SESSION['new_post']['new'] = array();
        $_SESSION['new_post']['new']['pages'] = array();
        $_GET['id'] = "new";
    }
    $_SESSION['new_post'][$_GET['id']]['remove_media'] = array();

?>
    <!-- Editor -->
    <link rel="stylesheet" type="text/css" href="plugins/simditor/simditor.css" />
    <script type="text/javascript" src="plugins/simditor/module.js"></script>
    <script type="text/javascript" src="plugins/simditor/hotkeys.js"></script>
    <script type="text/javascript" src="plugins/simditor/simditor.js"></script>
    <!-- Editor -->
    <div class="py-4">
        <div class="container g-0 px-3 mb-4">
            <div class="row justify-content-end gx-2">
                <div class="col">
                    <div class="dropdown">
                        <a class="dropdown-toggle bg-black p-2 lh-1 text-white text-decoration-none fw-bold d-inline-block rounded" href="javascript:void(0)" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-plus"></i> <span class="d-none d-lg-inline-block">Aggiungi</span> pagina
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a href="javascript:void(0)" class="dropdown-item" onclick="page_add();">Vuota</a></li>
                            <li><a href="javascript:void(0)" class="dropdown-item" onclick="">Template 1</a></li>
                            <li><a href="javascript:void(0)" class="dropdown-item" onclick="">Template 2</a></li>
                            <li><a href="javascript:void(0)" class="dropdown-item" onclick="">Template 3</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-auto">
                    <button onclick="modal('Salva post', '/php/edit_post/save_modal.php?id=<?php echo $_GET['id']; ?>', 2, 'modal-xl');" class="border-0 bg-success p-2 lh-1 text-white text-decoration-none fw-bold d-inline-block rounded"><i class="bi bi-check"></i> Salva</button>
                </div>
                <?php if ($_GET['id'] != "new") { ?>
                    <div class="col-auto">
                        <a href="<?php echo ["notizie", "recensioni", "monografie", "anteprime"][$post['type']] . "/{$post['id']}/" . strtourl($post['title']); ?>" target="_blank" class="border-0 bg-black p-2 lh-1 text-white text-decoration-none fw-bold d-inline-block rounded"><i class="bi bi-eye"></i> Visualizza</a>
                    </div>
                <?php } ?>
            </div>
        </div>
        <form id="post" action="/php/edit_post/save.php?id=<?php echo $_GET['id']; ?>"><?php foreach ($_SESSION['new_post'][$_GET['id']]['pages'] as $pi => $p) include $webRoot . "/php/edit_post/templates/page.php"; ?></form>
        <hr />
        <?php if ($_SESSION['user']['id'] == 1) { ?>
            <a href="javascript:void(0)" class="text-center d-block" onclick="$(this).next().toggle();">Debug</a>
        <?php } ?>
        <div id="array" class="container" style="display:none;"></div>
    </div>
    <script>
        function responsive(x, y, label) {
            var z = $(x).closest('.input-group');
            z.prev().html(label);
            z.find('select').attr('hidden', true);
            z.find('select[name=\'' + y + '\']').removeAttr('hidden').appendTo(z);
        }

        function save(btn) {
            btn.attr("disabled", true).css("opacity", "0.4");
            var form = $("form#post")
            var actionUrl = form.attr('action');
            $.ajax({
                type: "POST",
                url: actionUrl,
                data: new FormData(form[0]),
                processData: false,
                contentType: false,
                success: function(data) {
                    btn.attr("disabled", false).css("opacity", "1");
                    if (data == "removed") {
                        data = "?page=admin/manage_posts.php";
                        toast("Post eliminato!");
                    } else toast("Post salvato!");
                    loadpage(data, "#container", '', 'push');
                    open_modal.hide();
                },
                error: function(xhr, desc, err) {
                    console.log(err);
                }
            });
        }

        function page_add() {
            $.ajax({
                type: "GET",
                url: "php/edit_post/page_add.php?id=<?php echo $_GET['id']; ?>",
                data: "",
                async: false,
                success: function(data) {
                    $("#post").append(data);
                    get_session_post();
                }
            });
        }

        function page_remove(page, pi) {
            $.ajax({
                type: "GET",
                url: "php/edit_post/page_remove.php?id=<?php echo $_GET['id']; ?>&pi=" + pi,
                data: "",
                async: false,
                success: function(data) {
                    $(page).remove();
                    get_session_post();
                }
            });
        }

        function col_add(page, pi) {
            $.ajax({
                type: "GET",
                url: "php/edit_post/col_add.php?id=<?php echo $_GET['id']; ?>&pi=" + pi,
                data: "",
                async: false,
                success: function(data) {
                    $(page).find(".columns.spawn").append(data);
                    get_session_post();
                }
            });
        }

        function col_remove(col, pi, ci) {
            $.ajax({
                type: "GET",
                url: "php/edit_post/col_remove.php?id=<?php echo $_GET['id']; ?>&pi=" + pi + "&ci=" + ci,
                data: "",
                async: false,
                success: function(data) {
                    $(col).remove();
                    get_session_post();
                }
            });
        }

        function elem_add(col, pi, ci, type) {
            $.ajax({
                type: "GET",
                url: "php/edit_post/elem_add.php?id=<?php echo $_GET['id']; ?>&pi=" + pi + "&ci=" + ci + "&type=" + type,
                data: "",
                async: false,
                success: function(data) {
                    $(col).find(".elements.spawn").append(data);
                    get_session_post();
                }
            });
        }

        function elem_remove(elem, pi, ci, ei) {
            $.ajax({
                type: "GET",
                url: "php/edit_post/elem_remove.php?id=<?php echo $_GET['id']; ?>&pi=" + pi + "&ci=" + ci + "&ei=" + ei,
                data: "",
                async: false,
                success: function(data) {
                    $(elem).remove();
                    get_session_post();
                }
            });
        }

        function get_session_post() {
            $.ajax({
                type: "GET",
                url: "php/edit_post/get_session_post.php?id=<?php echo $_GET['id']; ?>",
                data: "",
                async: false,
                success: function(data) {
                    $("#array").html(data);
                }
            });

        }

        function swap(elem, pi, ci, ei, dir) {
            $.ajax({
                type: "GET",
                url: "php/edit_post/swap.php?id=<?php echo $_GET['id']; ?>&pi=" + pi + "&ci=" + ci + "&ei=" + ei + "&dir=" + dir,
                data: "",
                async: false,
                success: function(data) {
                    if (data != "") {
                        if (ci === "")
                            elem.html(data);
                        else
                            elem.replaceWith(data);

                        get_session_post();
                    }
                }
            });
        }
        get_session_post();
    </script>
    <style>
        #container {
            overflow: visible !important;
        }

        form#post:empty {
            padding: 2em;
        }

        form#post:empty:before,
        .elements.spawn:empty:before,
        .columns.spawn:empty:before {
            display: block;
            text-align: center;
            font-weight: bold;
            width: 100%;
        }

        form#post:empty:after,
        .elements.spawn:empty:after,
        .columns.spawn:empty:after {
            display: block;
            text-align: center;
            font-weight: bold;
            width: 100%;
        }

        form#post:empty:before {
            content: "\F4F8";
            font-family: bootstrap-icons !important;
            font-size: 3rem;
        }

        form#post:empty:after {
            content: "Inizia aggiungendo una pagina";
        }

        .columns.spawn:empty:after {
            content: "Nessuna colonna aggiunta";
            margin-top: 1rem;
        }

        .elements.spawn:empty:after {
            content: "Nessun elemento aggiunto";
            margin-top: 1rem;
        }
    </style>
<?php } ?>