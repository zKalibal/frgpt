<?php
session_start();
$element = &$_SESSION['new_post'][$_GET['id']]['pages'][$_GET['pi']]['columns'][$_GET['ci']]['elements'][$_GET['ei']];
?>
<form id="elem_form" class="m-0" action="php/edit_post/elem_save.php?id=<?php echo $_GET['id']; ?>&pi=<?php echo $_GET['pi']; ?>&ci=<?php echo $_GET['ci']; ?>&ei=<?php echo $_GET['ei']; ?>" enctype="multipart/form-data">
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
                    <select name="sizes[<?php echo $size; ?>]" class="form-select" data-selected="<?php echo $element['sizes'][$size]; ?>" <?php if ($size != "default") echo "hidden"; ?>>
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
                    <select name="style[display][<?php echo $size; ?>]" class="form-select" data-selected="<?php echo $element['style']['display'][$size]; ?>" <?php if ($size != "default") echo "hidden"; ?>>
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
        </div>
        <div class="col">
            <label>Bordi arrotondati</label>
            <select name="style[border-radius]" class="form-select" data-selected="<?php echo $element['style']['border-radius']; ?>">
                <option value="">No</option>
                <option value="rounded-4">Si</option>
                <option value="rounded-circle">Tondo</option>
            </select>
        </div>
    </div>
    <hr />
    <?php if ($_GET['type'] == "text") { ?>
        <div class="row">
            <div class="col">
                <label>Font</label>
                <select name="style[font-family]" class="form-select" data-selected="<?php echo $element['style']['font-family']; ?>">
                    <option value="sans-serif">Sans serif</option>
                    <option value="serif" selected>Serif</option>
                </select>
            </div>
            <div class="col">
                <label>Dimensione</label>
                <select name="style[font-size]" class="form-select" data-selected="<?php echo $element['style']['font-size']; ?>">
                    <option value="fs-6" selected>Normale</option>
                    <option value="fs-5">x1.25</option>
                    <option value="fs-4">x1.5</option>
                    <option value="fs-3">x1.75</option>
                    <option value="fs-2">x2</option>
                    <option value="fs-1">x2.5</option>
                    <option value="display-5">x3</option>
                    <option value="display-4">x3.5</option>
                    <option value="display-3">x4</option>
                    <option value="display-2">x4.5</option>
                    <option value="display-1">x5</option>
                </select>
            </div>
            <div class="col">
                <label>Tratto</label>
                <select name="style[font-weight]" class="form-select" data-selected="<?php echo $element['style']['font-weight']; ?>">
                    <option value="fw-light">Sottile</option>
                    <option value="fw-normal" selected>Normale</option>
                    <option value="fw-bold">Spesso</option>
                    <option value="fw-black">Molto spesso</option>
                </select>
            </div>
            <div class="col">
                <label>Allineamento default</label>
                <div class="input-group">
                    <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu">
                        <?php
                        foreach (["default", "sm", "md", "lg", "xl", "xxl"] as $size) {
                        ?>
                            <li><a class="dropdown-item font-capitalize" href="javascript:void(0)" onclick="responsive(this,'style[text-align][<?php echo $size; ?>]','Allineamento <?php echo $size; ?>');"><?php echo $size; ?></a></li>
                        <?php } ?>
                    </ul>
                    <?php
                    foreach (["sm", "md", "lg", "xl", "xxl", "default"] as $size) {
                    ?>
                        <select name="style[text-align][<?php echo $size; ?>]" class="form-select" data-selected="<?php echo $element['style']['text-align'][$size]; ?>" <?php if ($size != "default") echo "hidden"; ?>>
                            <?php
                            if ($size == "default")
                                $size = "";
                            else
                                $size = $size . "-";
                            ?>
                            <option value="">-</option>
                            <option value="text-<?php echo $size; ?>justify">Giustificato</option>
                            <option value="text-<?php echo $size; ?>start">Sinistra</option>
                            <option value="text-<?php echo $size; ?>center">Centro</option>
                            <option value="text-<?php echo $size; ?>end">Destra</option>
                        </select>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="col">
                <label>Interlinea</label>
                <select name="style[line-height]" class="form-select" data-selected="<?php echo $element['style']['line-height']; ?>">
                    <option value="lh-1">1</option>
                    <option value="lh-sm">1.25</option>
                    <option value="lh-base" selected>1.5 (normale)</option>
                    <option value="lh-lg">2</option>
                </select>
            </div>
            <div class="col">
                <label>Initial capital</label>
                <select name="style[initial-capital]" class="form-select" data-selected="<?php echo $element['style']['initial-capital']; ?>">
                    <option value="">No</option>
                    <option value="initial-capital">Si</option>
                </select>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col">
                <label>Colore sfondo</label>
                <select name="style[background-color]" class="form-select" data-selected="<?php echo $element['style']['background-color']; ?>">
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
                <select name="style[background-opacity]" class="form-select" data-selected="<?php echo $element['style']['background-opacity']; ?>">
                    <option value="">100%</option>
                    <option value="bg-opacity-75">75%</option>
                    <option value="bg-opacity-50">50%</option>
                    <option value="bg-opacity-25">25%</option>
                    <option value="bg-opacity-10">10%</option>
                    <option value="bg-opacity-3">3%</option>
                </select>
            </div>
            <div class="col">
                <label>Colore testo</label>
                <select name="style[color]" class="form-select" data-selected="<?php echo $element['style']['color']; ?>">
                    <option value="text-black">Nero</option>
                    <option value="text-white">Bianco</option>
                    <option value="text-blue">Blu</option>
                    <option value="text-red">Rosso</option>
                    <option value="text-yellow">Giallo</option>
                    <option value="text-green">Verde</option>
                    <option value="text-purple">Viola</option>
                </select>
            </div>
            <div class="col">
                <label>Trasparenza testo</label>
                <select name="style[text-opacity]" class="form-select" data-selected="<?php echo $element['style']['text-opacity']; ?>">
                    <option value="">100%</option>
                    <option value="text-opacity-75">75%</option>
                    <option value="text-opacity-50">50%</option>
                    <option value="text-opacity-25">25%</option>
                </select>
            </div>
            <div class="col">
                <label>Bordi</label>
                <select name="style[border]" class="form-select" data-selected="<?php echo $element['style']['border']; ?>">
                    <option value="">Nessun bordo</option>
                    <option value="border">Bordo perimetrale</option>
                </select>
            </div>
            <div class="col">
                <label>Bordi</label>
                <select name="style[border-color]" class="form-select" data-selected="<?php echo $element['style']['border-color']; ?>">
                    <option value=""></option>
                    <option value="border-black">Nero</option>
                    <option value="border-white">Bianco</option>
                </select>
            </div>
        </div>
        <hr />

        <!-- QUILLJS
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
        <div id="editor">
            <?php echo $element["content"]; ?>
        </div>
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
        <script>
            var quill = new Quill('#editor', {
                modules: {
                    toolbar: [
                        [{
                            header: [1, 2, false]
                        }],
                        ['bold', 'italic', 'underline', 'link'],
                        [{
                            'list': 'ordered'
                        }, {
                            'list': 'bullet'
                        }],
                        [{
                            'color': []
                        }, {
                            'background': []
                        }],
                        ['clean']
                    ]
                },
                placeholder: 'Scrivi un nuovo articolo',
                theme: 'snow' // or 'bubble'
            });

            quill.keyboard.bindings[13].unshift({
                key: 13,
                shiftKey: true,
                handler: (range, context) => {
                    $(quill.getLeaf(range.index)[0].parent.domNode).addClass("m-0");
                    return true;
                }
            });
            quill.on('text-change', function(delta, oldDelta, source) {
                if (source === 'user') {
                    delta.ops.forEach(function(op) {
                        if (op.hasOwnProperty('insert') && op.insert === '\n') {
                            $(quill.getLeaf(delta.ops[0]['retain']+1)[0].parent.domNode).removeAttr("class");
                        }
                    });
                }
            });
            quill.on('text-change', function(delta, oldDelta, source) {
                $("textarea[name='content']").val($("#editor>.ql-editor").html());
            })
        </script>
        <textarea name="content" hidden><?php echo $element["content"]; ?></textarea>
        QUILLJS-->

        <div class="input-group flex-nowrap mb-2">
            <textarea rows="10" name="content" class="form-control simditor" placeholder=""><?php echo $element["content"]; ?></textarea>
        </div>

        <hr />
    <?php
    } else if ($_GET['type'] == "image") {
    ?>
        <div class="row">
            <div class="col">
                <label>Cambia immagine</label>
                <div class="input-group mb-3">
                    <button class="btn btn-outline-secondary" type="button" onclick="file();">Scegli il file</button>
                    <input type="text" name="file_name" id="file_name" class="form-control" placeholder="Nessun file scelto" readonly="true">
                    <input type="text" name="file_blob" hidden="true">
                </div>
            </div>
            <div class="col">
                <label>Aspect ratio</label>
                <select name="style[ratio]" class="form-select" data-selected="<?php echo $element['style']['ratio']; ?>">
                    <option value="default" selected>Originale foto</option>
                    <option value="1x1">1:1</option>
                    <option value="4x3">4:3</option>
                    <option value="16x9">16:9</option>
                    <option value="21x9">21:9</option>
                </select>
            </div>
            <div class="col">
                <label>Cliccabile</label>
                <select name="style[clickable]" class="form-select" data-selected="<?php echo $element['style']['clickable']; ?>">
                    <option value="" selected>No</option>
                    <option value="clickable">Si</option>
                </select>
            </div>
        </div>
        <hr />
    <?php
    } else if ($_GET['type'] == "video") {
    ?>
        <div class="row">
            <div class="col">
                <label>Link</label>
                <div class="input-group mb-3">
                    <input type="text" name="content" class="form-control" placeholder="https://www.youtube.com/w=42903854" value="<?php echo $element["content"]; ?>">
                </div>
            </div>
        </div>
        <hr />
    <?php
    } else if ($_GET['type'] == "line") {
    ?>
        <div class="row">
            <div class="col">
                <label>Margine</label>
                <select name="style[vertical-margin]" class="form-select" data-selected="<?php echo $element['style']['vertical-margin']; ?>">
                    <option value=""></option>
                    <option value="my-0">Senza margine</option>
                    <option value="my-3">Con margine</option>
                </select>
            </div>
            <div class="col">
                <label>Colore</label>
                <select name="style[border-color]" class="form-select" data-selected="<?php echo $element['style']['border-color']; ?>">
                    <option value=""></option>
                    <option value="border-black">Nero</option>
                    <option value="border-white">Bianco</option>
                </select>
            </div>
        </div>
        <hr />
    <?php
    } else if ($_GET['type'] == "html") {
    ?>
        <div class="row">
            <div class="col">
                <label>Codice HTML</label>
                <div class="input-group mb-3">
                    <textarea type="text" name="content" class="form-control" placeholder="HTML code"><?php echo $element["content"]; ?></textarea>
                </div>
            </div>
        </div>
        <hr />
    <?php
    }
    ?>
    <button type="submit" class="btn btn-dark">Salva</button>
</form>
<script>
    //se viene cliccato il bottone per selezionare il file, genera un input temporanea e la clicca
    function file() {
        if (!$("input[name='temp_file'").length)
            $("form#post").append("<input name='temp_file' type='file' hidden='true' onchange='$(\"form#elem_form input#file_name\").val($(this)[0].files[0].name);'>");

        $("input[name='temp_file']").click();
    }

    //se il modal viene chiuso (e dunque non viene salvato) distrugge l'elemento input temporaneo
    $(".modal").on("hidden.bs.modal", function() {
        $("input[name='temp_file']").remove();
    });

    $("#elem_form").submit(function(e) {
        var file_name = "file_<?php echo "pi{$_GET['pi']}ci{$_GET['ci']}ei{$_GET['ei']}"; ?>";
        //se l'input temporanea viene trovata e ha un immagine al suo interno la fa diventare un input definitiva sostituendo il nome con quello effettivo dell'id dell'elemento
        if ($("input[name='temp_file'").length && $("input[name='temp_file']")[0].files.length != 0) {
            //ricava il file blob e lo passa al php in modo che possa restituire l'elemento con l'anteprima aggiornata
            $("input[name='file_blob']").val(window.URL.createObjectURL($("input[name='temp_file']")[0].files[0]));
            //rimuove l'eventuale file precedente per mantenerne sempre uno solo con lo steso file name
            $("input[name='" + file_name + "']").remove();
            //sostituisce il nome del file provvisorio col nome definitivo per l'upload
            $("input[name='temp_file']").attr("name", file_name);
        } else if ($("input[name='" + file_name + "']").length != 0) { //se viene salvato l'elemento senza che venga selezionato alcun file e trova un file settato nella input per l'upload, allora salva il file blob nel post in modo che venga caricato dal template.
            $("input[name='file_blob']").val(window.URL.createObjectURL($("input[name='" + file_name + "']")[0].files[0]));
        }
        e.preventDefault();
        var form = $(this);

        var actionUrl = form.attr('action');
        $.ajax({
            type: "POST",
            url: actionUrl,
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(data) {
                open_modal.hide();
                $(".pi<?php echo $_GET['pi']; ?>ci<?php echo $_GET['ci']; ?>ei<?php echo $_GET['ei']; ?>").replaceWith(data);
                get_session_post();
            },
            error: function(xhr, desc, err) {
                console.log(err);
            }
        });
    });
    $("select[data-selected!='']").each(function() {
        $(this).val($(this).attr("data-selected"));
    });
</script>
<?php ?>