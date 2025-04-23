<?php
session_start();
include "../../php/functions.php";
if ($_GET['id'] != "new")
    $r = security_query("SELECT title, short_description, meta_title, meta_description, type, platforms, ref_platform, rubric, subscriptions, featured, author_id, status, date from fr_posts where id = {$_GET['id']}", [])->fetch_assoc();
?>
<div class="row">
    <div class="col-12 col-md-6">
        <label><i class="bi bi-fonts"></i> Titolo post</label>
        <input form="post" type="text" name="title" class="form-control mb-4" placeholder="Scrivi il titolo dell'articolo" required="true" value="<?php echo $r['title']; ?>">
    </div>
    <div class="col-12 col-md-6">
        <label><i class="bi bi-fonts"></i> Titolo SEO</label>
        <input form="post" type="text" name="meta_title" class="form-control mb-4" placeholder="Titolo SEO (facoltativo)" value="<?php echo $r['meta_title']; ?>">
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-6">
        <label><i class="bi bi-blockquote-left"></i> Breve descrizione</label>
        <textarea form="post" name="short_description" class="form-control mb-4" placeholder="Scrivi una breve descrizione" required="true"><?php echo $r['short_description']; ?></textarea>
    </div>
    <div class="col-12 col-md-6">
        <label><i class="bi bi-blockquote-left"></i> Descrizione SEO</label>
        <textarea form="post" name="meta_description" class="form-control mb-4" placeholder="Descrizione SEO (facoltativa)"><?php echo $r['meta_description']; ?></textarea>
    </div>
</div>
<label><i class="bi bi-newspaper"></i> Tipologia</label>
<select form="post" name="type" class="form-select mb-4" data-selected="<?php echo $r['type']; ?>" required="true">
    <option value="0">Attualità</option>
    <option value="1">Recensione</option>
    <option value="2">Monografia</option>
    <option value="3">Anteprima</option>
</select>
<label><i class="bi bi-journal-text"></i> Rubrica</label>
<select form="post" name="rubric" class="form-select mb-4" data-selected="<?php echo $r['rubric']; ?>">
    <option value="">Nessuna</option>
    <?php
    $qr = security_query("SELECT * from fr_rubrics order by name asc", array());
    while ($rr = $qr->fetch_assoc()) {
    ?>
        <option value="<?php echo $rr['id']; ?>"><?php echo $rr['name']; ?></option>
    <?php
    }
    ?>
</select>
<label><i class="bi bi-controller"></i> Piattaforme</label>
<div class="mb-4">
    <?php
    $qp = security_query("SELECT * from fr_platforms order by name asc", array());
    while ($rp = $qp->fetch_assoc()) {
    ?>
        <div class="form-check form-check-inline">
            <input class="form-check-input" form="post" type="checkbox" name="platforms[]" value="<?php echo $rp['id']; ?>" <?php if (in_array($rp['id'], explode(",", $r['platforms']))) echo "checked"; ?>>
            <label class="form-check-label"><?php echo $rp['name']; ?></label>
        </div>
    <?php
    }
    ?>
</div>
<label><i class="bi bi-joystick"></i> Console di riferimento:</label>
<select form="post" name="ref_platform" class="form-select mb-4" data-selected="<?php echo $r['ref_platform']; ?>">
    <option value="">Nessuna</option>
    <?php
    $qp = security_query("SELECT * from fr_platforms order by name asc", array());
    while ($rp = $qp->fetch_assoc()) {
    ?>
        <option value="<?php echo $rp['id']; ?>"><?php echo $rp['name']; ?></option>
    <?php
    }
    ?>
</select>
<label><i class="bi bi-card-image"></i> Immagine anteprima</label>
<input form="post" type="file" name="image" class="form-control mb-4">
<label><i class="bi bi-twitch"></i> Sub richiesta</label>
<div class="mb-4">
    <?php
    $qc = security_query("SELECT * from fr_channels order by name asc", array());
    while ($rc = $qc->fetch_assoc()) {
    ?>
        <div class="form-check form-check-inline">
            <input class="form-check-input" form="post" type="checkbox" name="subscriptions[]" value="<?php echo $rc['id']; ?>" <?php if (in_array($rc['id'], explode(",", $r['subscriptions']))) echo "checked"; ?>>
            <label class="form-check-label"><?php echo $rc['name']; ?></label>
        </div>
    <?php
    }
    ?>
</div>
<label><i class="bi bi-person"></i> Autore:</label>
<select form="post" name="author" class="form-select mb-4" data-selected="<?php echo $r['author_id']; ?>" required="true">
    <?php
    $qa = security_query("SELECT * from fr_authors order by name asc", array());
    while ($ra = $qa->fetch_assoc()) {
    ?>
        <option value="<?php echo $ra['id']; ?>"><?php echo $ra['name']; ?></option>
    <?php
    }
    ?>
</select>
<div class="row align-items-end g-3">
    <div class="col">
        <label><i class="bi bi-send-check"></i> Stato post:</label>
        <select form="post" name="status" class="form-select" data-selected="<?php echo $r['status']; ?>" required="true">
            <option value="0">Bozza</option>
            <?php if ($_GET['id'] != "new") { ?>
                <option value="1">Pubblicato</option>
                <option value="delete">Elimina</option>
            <?php } ?>
        </select>
    </div>
    <?php if ($_GET['id'] != "new") { ?>
        <div class="col">
            <label><i class="bi bi-send-check"></i> Data pubblicazione:</label>
            <input form="post" type="datetime-local" name="date" class="form-control" placeholder="Data pubblicazione" required="true" value="<?php echo str_replace(" ", "T", $r['date']); ?>">
        </div>
    <?php } ?>
    <div class="col">
        <label><i class="bi bi-patch-exclamation"></i> In evidenza:</label>
        <select form="post" name="featured" class="form-select" data-selected="<?php echo $r['featured']; ?>" required="true">
            <option value="0">No</option>
            <option value="1">Si</option>
        </select>
    </div>
    <div class="col-auto">
        <button onclick="if ($('form#post')[0].reportValidity())
                    save($(this));" class="btn btn-dark"><i class="bi bi-check"></i> Salva post</button>
    </div>
</div>
<script>
    $("select[data-selected!='']").each(function() {
        $(this).val($(this).attr("data-selected"));
    });
</script>