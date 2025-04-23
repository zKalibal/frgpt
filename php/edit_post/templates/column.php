<?php
$column = $_SESSION['new_post'][$_GET['id']]['pages'][$pi]['columns'][$ci];
?>
<div class="column <?php
echo "pi{$pi}ci{$ci} ";
echo implode(' ', $column['sizes']);
echo ($column['style']['border-radius']!="") ? " {$column['style']['border-radius']} overflow-hidden" : "";
?>">
    <div style="box-shadow: 0px 0px 0px 1px #fffff645;background: rgba(0,0,0,0.01);" class="p-3 h-100 <?php echo "{$column['style']['background-color']} {$column['style']['background-opacity']}"; ?>">
        <div class="row justify-content-end g-2">
            <div class="col">
                <div class="dropdown">
                    <a class="dropdown-toggle bg-white shadow-sm rounded-pill p-2 lh-1 text-black text-decoration-none fw-bold d-inline-block" href="javascript:void(0)" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-plus"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li><a href="javascript:void(0)" class="dropdown-item" onclick="elem_add($(this).closest('.column'),<?php echo $pi; ?>,<?php echo $ci; ?>, 'text');"><i class="bi bi-paragraph"></i> Testo</a></li>
                        <li><a href="javascript:void(0)" class="dropdown-item" onclick="elem_add($(this).closest('.column'),<?php echo $pi; ?>,<?php echo $ci; ?>, 'line');"><i class="bi bi-hr"></i> Linea</a></li>
                        <li><a href="javascript:void(0)" class="dropdown-item" onclick="elem_add($(this).closest('.column'),<?php echo $pi; ?>,<?php echo $ci; ?>, 'image');"><i class="bi bi-image"></i> Immagine</a></li>
                        <li><a href="javascript:void(0)" class="dropdown-item" onclick="elem_add($(this).closest('.column'),<?php echo $pi; ?>,<?php echo $ci; ?>, 'video');"><i class="bi bi-play-btn"></i> Video</a></li>
                        <li><a href="javascript:void(0)" class="dropdown-item" onclick="elem_add($(this).closest('.column'),<?php echo $pi; ?>,<?php echo $ci; ?>, 'html');"><i class="bi bi-code-slash"></i> HTML</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-auto">
                <a href="javascript:void(0)" onclick="swap($(this).closest('.page'),<?php echo "$pi,$ci,''"; ?>, 'up')" class="bg-white shadow-sm rounded-pill p-2 text-black text-decoration-none fw-bold d-inline-block"><i class="bi bi-arrow-left"></i></a>
            </div>
            <div class="col-auto">
                <a href="javascript:void(0)" onclick="swap($(this).closest('.page'),<?php echo "$pi,$ci,''"; ?>, 'down')" class="bg-white shadow-sm rounded-pill p-2 text-black text-decoration-none fw-bold d-inline-block"><i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="col-auto">
                <a href="javascript:void(0)" onclick="modal('Modifica colonna', '/php/edit_post/col_modal.php?id=<?php echo $_GET['id'];?>&pi=<?php echo $pi; ?>&ci=<?php echo $ci; ?>', 2, 'modal-xl')" class="bg-white shadow-sm rounded-pill p-2 text-black text-decoration-none fw-bold d-inline-block"><i class="bi bi-pencil"></i></a>
            </div>
            <div class="col-auto">
                <a href="javascript:void(0)" onclick="col_remove($(this).closest('.column'),<?php echo $pi; ?>,<?php echo $ci; ?>);" class="bg-white shadow-sm rounded-pill p-2 text-black text-decoration-none fw-bold d-inline-block"><i class="bi bi-trash"></i></a>
            </div>
        </div>
        <hr/>
        <div class="elements spawn row <?php echo "{$column['style']['vertical-gap']} {$column['style']['horizontal-gap']} {$column['style']['vertical-align']} {$column['style']['horizontal-align']}"; ?>" style="height: calc(100% - 3em - 3px);"><?php
            if ($last_id == "")
                foreach ($column['elements'] as $ei => $e) {
                    include "element.php";
                }
            
        ?></div>
    </div>
</div>