<?php
include_once ($webRoot = str_replace($_SERVER['PHP_SELF'], "", $_SERVER['SCRIPT_FILENAME'])) . "/php/functions.php";
$element = $_SESSION['new_post'][$_GET['id']]['pages'][$pi]['columns'][$ci]['elements'][$ei];
?>
<div class="element <?php
                    if ($column['style']['vertical-align'] == "align-content-stretch")
                        echo "d-flex ";
                    echo "pi{$pi}ci{$ci}ei{$ei} ";
                    echo implode(' ', $element['sizes']);
                    ?>">
    <div style="box-shadow: 0px 0px 0px 1px #fffff645; background-color:rgba(0,0,0,0.01);" class="p-3 w-100 <?php echo "{$element['style']['background-color']} {$element['style']['background-opacity']}"; ?>">
        <div class="row justify-content-end g-2">
            <div class="col"></div>
            <div class="col-auto">
                <a href="javascript:void(0)" onclick="swap($(this).closest('.column'),<?php echo "$pi,$ci,$ei"; ?>, 'up')" class="bg-white shadow-sm rounded-pill p-2 text-black text-decoration-none fw-bold d-inline-block"><i class="bi bi-arrow-up"></i></a>
            </div>
            <div class="col-auto">
                <a href="javascript:void(0)" onclick="swap($(this).closest('.column'),<?php echo "$pi,$ci,$ei"; ?>, 'down')" class="bg-white shadow-sm rounded-pill p-2 text-black text-decoration-none fw-bold d-inline-block"><i class="bi bi-arrow-down"></i></a>
            </div>
            <div class="col-auto">
                <a href="javascript:void(0)" onclick="modal('Modifica elemento', '/php/edit_post/elem_modal.php?id=<?php echo $_GET['id']; ?>&pi=<?php echo $pi; ?>&ci=<?php echo $ci; ?>&ei=<?php echo $ei; ?>&type=<?php echo $element['type']; ?>', 2, 'modal-xl')" class="bg-white shadow-sm rounded-pill p-2 text-black text-decoration-none fw-bold d-inline-block"><i class="bi bi-pencil"></i></a>
            </div>
            <div class="col-auto">
                <a href="javascript:void(0)" onclick="elem_remove($(this).closest('.element'), <?php echo $pi; ?>, <?php echo $ci; ?>, <?php echo $ei; ?>)" class="bg-white shadow-sm rounded-pill p-2 text-black text-decoration-none fw-bold d-inline-block"><i class="bi bi-trash"></i></a>
            </div>
        </div>
        <hr />
        <div class="content <?php echo ($element['style']['border-radius'] != "") ? " {$element['style']['border-radius']} overflow-hidden" : ""; ?>">
            <?php
            if ($element['type'] == "text") {
                if ($element['content'] != "") {
                    echo "<div class='{$element['style']['font-family']} {$element['style']['color']} {$element['style']['text-opacity']} {$element['style']['font-size']} {$element['style']['font-weight']} " . implode(' ', $element['style']['text-align']) . " {$element['style']['line-height']}'>{$element['content']}</div>";
                }
            } else
            if ($element['type'] == "image") {
                if (($image = $_POST['file_blob']) != "");
                else if (file_exists("$webRoot/" . ($image = "img/posts/{$_GET['id']}_{$pi}_{$ci}_{$ei}.webp")))
                    $image .= "?t=" . filemtime("$webRoot/$image");
                else
                    $image = "img/default.webp";

                if ($element['style']['ratio'] == "default" || $element['style']['ratio'] == "")
                    echo "<img class='w-100' src='{$image}'>";
                else
                    echo "<div class='img ratio ratio-{$element['style']['ratio']}' style='background-image:url({$image})'></div>";
            } else if ($element['type'] == "video") {
            ?>
                <div class="ratio ratio-16x9">
                    <iframe src="<?php echo str_replace("watch?v=", "embed/", $element['content']); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            <?php
            } else if ($element['type'] == "line") {
            ?>
                <div class="border-bottom border-2 <?php echo $element['style']['border-color']; ?> my-3"></div>
            <?php
            } else if ($element['type'] == "html") {
                echo $element['content'];
            }
            ?>
        </div>
    </div>
</div>