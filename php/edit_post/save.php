<?php

session_start();
include "../../php/functions.php";
if (security_query("SELECT admin from fr_users where id = [i]", array($_SESSION['user']['id']))->fetch_assoc()['admin'] != 1) {
    redirect("/");
    exit();
} else {

    if ($_POST['status'] == "delete") {
        /* elimina tutte le foto del post*/
        array_map('unlink', glob('../../img/posts/' . $_GET['id'] . '_*.*'));
        unlink("../../img/posts/" . $_GET['id'] . ".webp");
        security_query("DELETE from fr_posts where id = [i]", array($_GET['id']));
        echo "removed";
    } else {
        $_SESSION['new_post'][$_GET['id']]['pages'] = removeNullValues($_SESSION['new_post'][$_GET['id']]['pages']);

        $data = json_encode($_SESSION['new_post'][$_GET['id']]);

        if ($_GET['id'] != "new") { //se non è un post appena creato

            security_query(
                "UPDATE fr_posts set title=[s], short_description = [s], meta_title=[s], meta_description = [s], type = [i], platforms = [s], ref_platform=[i], rubric = [i], subscriptions = [s], content = [s], featured = [i], author_id = [i], status = [i], date = [s] where id = {$_GET['id']}",
                [
                    $_POST['title'],
                    $_POST['short_description'],
                    (($_POST['meta_title'] != "") ? $_POST['meta_title'] : NULL),
                    (($_POST['meta_description'] != "") ? $_POST['meta_description'] : NULL),
                    $_POST['type'],
                    implode(",", $_POST['platforms']),
                    (($_POST['ref_platform'] != "") ? $_POST['ref_platform'] : NULL),
                    (($_POST['rubric'] != "") ? $_POST['rubric'] : NULL),
                    implode(",", $_POST['subscriptions']),
                    $data,
                    $_POST['featured'],
                    $_POST['author'],
                    $_POST['status'],
                    $_POST['date']
                ]
            );
            $id = $_GET['id'];

            //cicla le foto da cancellare e le elimina
            foreach ($_SESSION['new_post'][$id]['remove_media'] as $ri => $remove) {
                unlink("../../$remove");
                unlink("../../" . explode(".", $remove)[0] . "_large." . explode(".", $remove)[1]);
                unlink("../../" . explode(".", $remove)[0] . "_medium." . explode(".", $remove)[1]);
                unlink("../../" . explode(".", $remove)[0] . "_thumb." . explode(".", $remove)[1]);
            }
        } else { //se è un nuovo post
            security_query(
                "INSERT into fr_posts (title,short_description,meta_title,meta_description,type,platforms,ref_platform,rubric,subscriptions,featured,content,author_id,status) values ([s],[s],[s],[s],[i],[s],[i],[i],[s],[i],[s],[i],[i])",
                [
                    $_POST['title'],
                    $_POST['short_description'],
                    $_POST['meta_title'],
                    $_POST['meta_description'],
                    $_POST['type'],
                    implode(",", $_POST['platforms']),
                    (($_POST['ref_platform'] != "") ? $_POST['ref_platform'] : NULL),
                    (($_POST['rubric'] != "") ? $_POST['rubric'] : NULL),
                    implode(",", $_POST['subscriptions']),
                    $_POST['featured'],
                    $data,
                    $_POST['author'],
                    $_POST['status']
                ]
            );
            $id = security_query("SELECT id from fr_posts order by id desc", [])->fetch_assoc()['id'];
            $_SESSION['new_post'][$id] = $_SESSION['new_post'][$_GET['id']];
        }

        //cicla tutti gli elementi per cercare eventuali foto da uploaddare
        foreach ($_SESSION['new_post'][$id]['pages'] as $pi => $page) {
            foreach ($page['columns'] as $ci => $col) {
                foreach ($col['elements'] as $ei => $elem) {
                    if ($elem['type'] == "image" && strpos($_FILES['file_pi' . $pi . 'ci' . $ci . 'ei' . $ei]['type'], 'image') !== false) {
                        $fileName = "{$id}_{$pi}_{$ci}_{$ei}";
                        if (upload_photo($_FILES['file_pi' . $pi . 'ci' . $ci . 'ei' . $ei], "../../img/posts/{$fileName}.webp")) {

                            $image = imagecreatefromstring(file_get_contents("../../img/posts/{$fileName}.webp"));

                            $resize = imagescale($image, 1024);
                            imagewebp($resize, "../../img/posts/{$fileName}_large.webp");

                            $resize = imagescale($image, 300);
                            imagewebp($resize, "../../img/posts/{$fileName}_medium.webp");

                            $resize = imagescale($image, 150);
                            imagewebp($resize, "../../img/posts/{$fileName}_thumb.webp");
                        }
                    }
                }
            }
        }
        /* UPLOAD FOTO ANTEPRIMA POST */
        if (strpos($_FILES['image']['type'], 'image') !== false) {
            if (upload_photo($_FILES['image'], "../../img/posts/$id.webp")) {

                $image = imagecreatefromstring(file_get_contents("../../img/posts/$id.webp"));

                $resize = imagescale($image, 1024);
                imagewebp($resize, "../../img/posts/{$id}_large.webp");

                $resize = imagescale($image, 300);
                imagewebp($resize, "../../img/posts/{$id}_medium.webp");

                $resize = imagescale($image, 150);
                imagewebp($resize, "../../img/posts/{$id}_thumb.webp");
            }
        }
        /* UPLOAD FOTO ANTEPRIMA POST */
        echo "?page=admin/new_post.php?id={$id}";
    }
}
