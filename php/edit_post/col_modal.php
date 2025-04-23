<?php
session_start();
$column = &$_SESSION['new_post'][$_GET['id']]['pages'][$_GET['pi']]['columns'][$_GET['ci']];
?>
<form id="col_form" class="m-0" action="php/edit_post/col_save.php?id=<?php echo $_GET['id']; ?>&pi=<?php echo $_GET['pi']; ?>&ci=<?php echo $_GET['ci']; ?>">
    <div class="row">
        <div class="col">
            <label>Col default</label>
            <div class="input-group">
                <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu">
                    <?php
                    foreach (["default", "sm", "md", "lg", "xl", "xxl"] as $size) {
                    ?>
                        <li><a class="dropdown-item font-capitalize" href="javascript:void(0)" onclick="responsive(this,'sizes[<?php echo $size; ?>]','Col <?php echo $size; ?>');"><?php echo $size; ?></a></li>
                    <?php } ?>
                </ul>
                <?php
                foreach (["sm", "md", "lg", "xl", "xxl", "default"] as $size) {
                ?>
                    <select name="sizes[<?php echo $size; ?>]" class="form-select" data-selected="<?php echo $column['sizes'][$size]; ?>" <?php if ($size != "default") echo "hidden"; ?>>
                        <?php
                        if ($size == "default")
                            $size = "";
                        else
                            $size =  "-" . $size;
                        ?>
                        <option value="">-</option>
                        <option value="col<?php echo $size; ?>-auto">Adatta</option>
                        <option value="col<?php echo $size; ?>">Split equo</option>
                        <option value="col<?php echo $size; ?>-12">12/12 (100%)</option>
                        <option value="col<?php echo $size; ?>-11">11/12</option>
                        <option value="col<?php echo $size; ?>-10">10/12</option>
                        <option value="col<?php echo $size; ?>-9">9/12 (75%)</option>
                        <option value="col<?php echo $size; ?>-8">8/12</option>
                        <option value="col<?php echo $size; ?>-7">7/12</option>
                        <option value="col<?php echo $size; ?>-6">6/12 (50%)</option>
                        <option value="col<?php echo $size; ?>-5">5/12</option>
                        <option value="col<?php echo $size; ?>-4">4/12</option>
                        <option value="col<?php echo $size; ?>-3">3/12 (25%)</option>
                        <option value="col<?php echo $size; ?>-2">2/12</option>
                        <option value="col<?php echo $size; ?>-1">1/12</option>
                    </select>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="col">
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
                    <select name="style[display][<?php echo $size; ?>]" class="form-select" data-selected="<?php echo $column['style']['display'][$size]; ?>" <?php if ($size != "default") echo "hidden"; ?>>
                        <?php
                        if ($size == "default")
                            $size = "";
                        else
                            $size =  "-" . $size;
                        ?>
                        <option value="">-</option>
                        <option value="d<?php echo $size; ?>-flex">Mostra</option>
                        <option value="d<?php echo $size; ?>-none">Nascondi</option>
                    </select>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col">
            <label>Allineamento verticale elementi</label>
            <select name="style[vertical-align]" class="form-select" data-selected="<?php echo $column['style']['vertical-align']; ?>">
                <option value="align-content-start">Inizio</option>
                <option value="align-content-center">Centro</option>
                <option value="align-content-end">Fine</option>
                <option value="align-content-between">Distanzia</option>
                <option value="align-content-stretch">Riempi</option>
            </select>
        </div>
        <div class="col">
            <label>Allineamento orizzontale elementi</label>
            <select name="style[horizontal-align]" class="form-select" data-selected="<?php echo $column['style']['horizontal-align']; ?>">
                <option value="justify-content-start">Sinistra</option>
                <option value="justify-content-center">Centro</option>
                <option value="justify-content-end">Destra</option>
                <option value="justify-content-around">Equa distanza con margini</option>
                <option value="justify-content-evenly">Equa distanza senza margini</option>
                <option value="justify-content-between">Distanzia</option>
            </select>
        </div>
        <div class="col">
            <label>Gap verticale elementi</label>
            <select name="style[vertical-gap]" class="form-select" data-selected="<?php echo $column['style']['vertical-gap']; ?>">
                <option value="gy-0">Nessuno</option>
                <option value="gy-1">1</option>
                <option value="gy-2">2</option>
                <option value="gy-3">3</option>
                <option value="gy-4">4 (standard)</option>
                <option value="gy-5">5</option>
                <option value="gy-6">6</option>
            </select>
        </div>
        <div class="col">
            <label>Gap orizzontale elementi</label>
            <select name="style[horizontal-gap]" class="form-select" data-selected="<?php echo $column['style']['horizontal-gap']; ?>">
                <option value="gx-0">Nessuno</option>
                <option value="gx-1">1</option>
                <option value="gx-2">2</option>
                <option value="gx-3">3</option>
                <option value="gx-4">4 (standard)</option>
                <option value="gx-5">5</option>
                <option value="gx-6">6</option>
            </select>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col">
            <label>Colore sfondo</label>
            <select name="style[background-color]" class="form-select" data-selected="<?php echo $column['style']['background-color']; ?>">
                <option value="" selected>Trasparente</option>
                <option value="bg-white">Bianco</option>
                <option value="bg-black">Nero</option>
                <option value="bg-black000">Nero quello vero</option>
                <option value="bg-blue">Blu</option>
                <option value="bg-red">Rosso</option>
                <option value="bg-yellow">Giallo</option>
                <option value="bg-green">Verde</option>
                <option value="bg-purple">Viola</option>
            </select>
        </div>
        <div class="col">
            <label>Trasparenza sfondo</label>
            <select name="style[background-opacity]" class="form-select" data-selected="<?php echo $column['style']['background-opacity']; ?>">
                <option value="">100%</option>
                <option value="bg-opacity-75">75%</option>
                <option value="bg-opacity-50">50%</option>
                <option value="bg-opacity-25">25%</option>
                <option value="bg-opacity-10">10%</option>
                <option value="bg-opacity-3">3%</option>
            </select>
        </div>
        <div class="col">
            <label>Bordi arrotondati</label>
            <select name="style[border-radius]" class="form-select" data-selected="<?php echo $column['style']['border-radius']; ?>">
                <option value="">No</option>
                <option value="rounded-4">Si</option>
            </select>
        </div>
    </div>
    <hr />
    <button type="submit" class="btn btn-dark">Salva</button>
</form>
<script>
    $("#col_form").submit(function(e) {

        e.preventDefault();

        var form = $(this);
        var actionUrl = form.attr('action');

        $.ajax({
            type: "POST",
            url: actionUrl,
            data: form.serialize(),
            success: function(data) {
                open_modal.hide();
                $(".pi<?php echo $_GET['pi']; ?>ci<?php echo $_GET['ci']; ?>").replaceWith(data);
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