<?php
session_start();
include_once ($webRoot = str_replace($_SERVER['PHP_SELF'], "", $_SERVER['SCRIPT_FILENAME'])) . "/php/functions.php";
if ($_SESSION['user']['admin'] != 1) { //se non è admin
    setHeaders(["redirect" => "/"]);
} else {

    //HEADER 
    setHeaders([
        "meta-title" => "Gestione posts",
        "meta-robots" => "noindex"
    ]);
?>
    <div class="blur-backdrop overflow-hidden wow fadeIn">
        <?php include("include/nav.php"); ?>
        <div class="container py-4 px-3 px-lg-0">
            <?php
            foreach ($_SESSION['alert'] as $key => $value) {
            ?>
                <div class="alert alert-<?php echo $value['style']; ?> mb-4" role="alert"><?php echo $value['message']; ?></div>
            <?php
            }
            unset($_SESSION['alert']);
            ?>
            <center>
                <h2 class="fw-semibold">Elenco post</h2>
                <a href="?page=admin/new_post.php" class="spa mb-4 border-0 bg-black p-2 lh-1 text-white text-decoration-none fw-bold d-inline-block rounded"><i class="bi bi-plus"></i> Crea nuovo</a>
            </center>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Anteprima</th>
                            <th scope="col">Titolo</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Autore</th>
                            <th scope="col">Stato</th>
                            <th scope="col">Data pubblicazione</th>
                            <th scope="col">Views</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        <?php
                        $q = security_query("SELECT fr_posts.*, fr_authors.name as 'author_name' from fr_posts inner join fr_authors on fr_authors.id = fr_posts.author_id $where group by fr_posts.id order by status asc, date desc", array());
                        if (mysqli_num_rows($q) == 0) {
                        ?>
                            <center>
                                <p>Nessun articolo trovato!</p>
                            </center>
                            <?php
                        } else {
                            while ($r = $q->fetch_assoc()) {
                                $status = ["Bozza", "Pubblicato"];
                            ?>
                                <tr>
                                    <td>
                                        <div class="img ratio ratio-4x3 zoom" style="<?php if (file_exists($webRoot . '/img/posts/' . $r['id'] . '.webp')) { ?> background-image: url('/img/posts/<?php echo $r['id']; ?>.webp');<?php } ?>"></div>
                                    </td>
                                    <td class="text-truncate"><?php echo $r['title']; ?></td>
                                    <td><?php echo ["notizie", "recensione", "monografia", "anteprima"][$r['type']]; ?></td>
                                    <td><?php echo $r['author_name']; ?></td>
                                    <td><?php echo $status[$r['status']]; ?></td>
                                    <td><?php if ($r['date'] != NULL) echo date("d/m/Y", strtotime($r['date']));
                                        else echo "Non pubblicato"; ?>
                                    </td>
                                    <td><?php echo $r['views']; ?></td>
                                    <td>
                                        <a href="<?php echo ["notizie", "recensioni", "monografie", "anteprime"][$r['type']]; ?>/<?php echo $r['id']; ?>/<?php echo strtourl($r['title']); ?>" class="spa border-0 bg-black p-2 lh-1 text-white text-decoration-none fw-bold d-block text-center rounded"><i class="bi bi-eye"></i></a>
                                    </td>
                                    <td>
                                        <a href="?page=admin/new_post.php?id=<?php echo $r['id']; ?>" class="spa border-0 bg-black p-2 lh-1 text-white text-decoration-none fw-bold d-block text-center rounded"><i class="bi bi-pen"></i></a>
                                    </td>
                                </tr>

                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php } ?>