<?php
$page = $_SESSION['new_post'][$_GET['id']]['pages'][$pi];
?>
<style>
    <?php
    if($page['style']['bold-color']!="") 
        echo ".pi$pi .element b, .pi$pi .element strong, .pi$pi .element a{color:{$page['style']['bold-color']};}"; 
    ?>
</style>
<div class="page p-0 <?php
echo "pi{$pi} ";
if ($page['style']['container'] != "container-inner")
    echo "{$page['style']['container']} ";
echo "{$page['style']['container']} ";
echo "{$page['style']['vertical-margin']} ";
echo "{$page['style']['background-color']} ";
echo "{$page['style']['background-opacity']} ";
?>">
    <div class="p-3 <?php
    if ($page['style']['container'] == "container-inner")
        echo "container ";
    ?>" style="box-shadow: 0px 0px 0px 1px #fffff645;background: rgba(0,0,0,0.01);">
        <div class="row g-2 justify-content-end align-items-center">
            <div class="col">
                <a href="javascript:void(0)" onclick="col_add($(this).closest('.page'),<?php echo $pi; ?>);" class="bg-white shadow-sm rounded-pill p-2 lh-1 text-black text-decoration-none fw-bold d-inline-block"><i class="bi bi-plus"></i> <span class="d-none d-lg-inline-block">Aggiungi</span> colonna</a>
            </div>
            <div class="col-auto">
                <a href="javascript:void(0)" onclick="swap($(this).closest('#post'),<?php echo "$pi"; ?>, '', '', 'up')" class="bg-white shadow-sm rounded-pill p-2 text-black text-decoration-none fw-bold d-inline-block"><i class="bi bi-arrow-up"></i></a>
            </div>
            <div class="col-auto">
                <a href="javascript:void(0)" onclick="swap($(this).closest('#post'),<?php echo "$pi"; ?>, '', '', 'down')" class="bg-white shadow-sm rounded-pill p-2 text-black text-decoration-none fw-bold d-inline-block"><i class="bi bi-arrow-down"></i></a>
            </div>
            <div class="col-auto">
                <a href="javascript:void(0)" onclick="modal('Modifica pagina', '/php/edit_post/page_modal.php?id=<?php echo $_GET['id'];?>&pi=<?php echo $pi; ?>', 2, 'modal-xl')" class="bg-white shadow-sm rounded-pill p-2 text-black text-decoration-none fw-bold d-inline-block"><i class="bi bi-pencil"></i></a>
            </div>
            <div class="col-auto">
                <a href="javascript:void(0)" onclick="page_remove($(this).closest('.page'),<?php echo $pi; ?>);" class="bg-white shadow-sm rounded-pill p-2 text-black p-2 text-decoration-none fw-bold d-inline-block"><i class="bi bi-trash"></i></a>
            </div>
        </div>
        <hr/>
        <div class="columns spawn row <?php 
        /* classi */
        echo ($page['style']['col-horizontal-gap']!="") ? "{$page['style']['col-horizontal-gap']} " : "gx-4 ";
        echo ($page['style']['col-vertical-gap']!="") ? "{$page['style']['col-vertical-gap']} " : "gy-4 ";
        echo $page['style']['justify-content']; 
        /* classi */
        ?>"><?php
            if ($last_id == "")
                foreach ($page['columns'] as $ci => $c) {
                    include "column.php";
                }
        ?></div>
    </div>
</div>