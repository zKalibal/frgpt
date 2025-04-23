<?php
session_start();
$page = &$_SESSION['new_post'][$_GET['id']]['pages'][$_GET['pi']];
?>
<form id="page_form" class="m-0" action="php/edit_post/page_save.php?id=<?php echo $_GET['id']; ?>&pi=<?php echo $_GET['pi']; ?>">
    <label>Visibilità default</label>
    <div class="input-group">
        <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="visually-hidden">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu">
            <?php
            foreach (["default", "sm", "md", "lg", "xl", "xxl"] as $size) {
            ?>
                <li><a class="dropdown-item font-capitalize" href="javascript:void(0)" onclick="responsive(this,'style[display][<?php echo $size; ?>]','Visibilità <?php echo $size; ?>');"><?php echo $size; ?></a></li>
            <?php } ?>
        </ul>
        <?php
        foreach (["sm", "md", "lg", "xl", "xxl", "default"] as $size) {
        ?>
            <select name="style[display][<?php echo $size; ?>]" class="form-select" data-selected="<?php echo $page['style']['display'][$size]; ?>" <?php if ($size != "default") echo "hidden"; ?>>
                <?php
                if ($size == "default")
                    $size = "";
                else
                    $size =  "-" . $size;
                ?>
                <option value="">-</option>
                <option value="d<?php echo $size; ?>-block">Mostra</option>
                <option value="d<?php echo $size; ?>-none">Nascondi</option>
            </select>
        <?php
        }
        ?>
    </div>
    <hr />
    <div class="row">
        <div class="col">
            <label>Larghezza pagina</label>
            <select name="style[container]" class="form-select" data-selected="<?php echo $page['style']['container']; ?>">
                <option value="container" selected>Boxa</option>
                <option value="container-inner" selected>Boxa contenuto</option>
                <option value="container-fluid">Full screen</option>
            </select>
        </div>
        <div class="col">
            <label>Margini verticali</label>
            <select name="style[vertical-margin]" class="form-select" data-selected="<?php echo $page['style']['vertical-margin']; ?>">
                <option value="" selected>Senza margini</option>
                <option value="my-1">1</option>
                <option value="my-2">2</option>
                <option value="my-3">3</option>
                <option value="my-4">4 (standard)</option>
                <option value="my-5">5</option>
                <option value="my-6">6</option>
            </select>
        </div>
        <div class="col">
            <label>Allinea colonne</label>
            <select name="style[justify-content]" class="form-select" data-selected="<?php echo $page['style']['justify-content']; ?>">
                <option value="justify-content-start">Sinistra</option>
                <option value="justify-content-center">Centro</option>
                <option value="justify-content-end">Destra</option>
                <option value="justify-content-around">Equa distanza con margini</option>
                <option value="justify-content-evenly">Equa distanza senza margini</option>
                <option value="justify-content-between">Distanzia</option>
            </select>
        </div>
        <div class="col">
            <label>Bordi tra colonne</label>
            <select name="style[col-border]" class="form-select" data-selected="<?php echo $page['style']['col-border']; ?>">
                <option value="" selected>Senza bordi</option>
                <option value="border-solid">Bordo solido</option>
                <option value="border-dashed">Bordo tratteggiato</option>
            </select>
        </div>
        <div class="col">
            <label>Colore bordo</label>
            <select name="style[col-border-color]" class="form-select" data-selected="<?php echo $page['style']['col-border-color']; ?>">
                <option value="border-black">Nero</option>
                <option value="border-white">Bianco</option>
            </select>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-6">
            <label>Gap verticale colonne</label>
            <select name="style[col-vertical-gap]" class="form-select" data-selected="<?php echo $page['style']['col-vertical-gap']; ?>">
                <option value="gy-4">4 (standard)</option>
                <option value="gy-0">Nessuno</option>
            </select>
        </div>
        <div class="col-6">
            <label>Gap orizzontale colonne</label>
            <select name="style[col-horizontal-gap]" class="form-select" data-selected="<?php echo $page['style']['col-horizontal-gap']; ?>">
                <option value="gx-4">4 (standard)</option>
                <option value="gx-0">Nessuno</option>
            </select>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col">
            <label>Colore grassetto</label>
            <input type="text" name="style[bold-color]" class="form-control mb-4" placeholder="" value="<?php echo $page['style']['bold-color']; ?>">
        </div>
        <div class="col">
            <label>Sfondo pagina</label>
            <select name="style[background-color]" class="form-select" data-selected="<?php echo $page['style']['background-color']; ?>">
                <option value="" selected>Trasparente</option>
                <option value="bg-white">Bianco</option>
                <option value="bg-black">Nero</option>
                <option value="bg-blue">Blu</option>
                <option value="bg-red">Rosso</option>
                <option value="bg-yellow">Giallo</option>
                <option value="bg-green">Verde</option>
                <option value="bg-purple">Viola</option>
            </select>
        </div>
        <div class="col">
            <label>Trasparenza sfondo</label>
            <select name="style[background-opacity]" class="form-select" data-selected="<?php echo $page['style']['background-opacity']; ?>">
                <option value="">100%</option>
                <option value="bg-opacity-75">75%</option>
                <option value="bg-opacity-50">50%</option>
                <option value="bg-opacity-25">25%</option>
                <option value="bg-opacity-10">10%</option>
                <option value="bg-opacity-3">3%</option>
            </select>
        </div>
    </div>
    <hr />
    <button type="submit" class="btn btn-dark">Salva</button>
</form>
<script>
    $("#page_form").submit(function(e) {

        e.preventDefault();

        var form = $(this);
        var actionUrl = form.attr('action');

        $.ajax({
            type: "POST",
            url: actionUrl,
            data: form.serialize(),
            success: function(data) {
                open_modal.hide();
                $(".pi<?php echo $_GET['pi']; ?>").replaceWith(data);
                get_session_post();
            }
        });
    });
    $("select[data-selected!='']").each(function() {
        $(this).val($(this).attr("data-selected"));
    });
</script>
<?php
?>