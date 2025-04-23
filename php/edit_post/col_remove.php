<?php

session_start();
$column = &$_SESSION['new_post'][$_GET['id']]['pages'][$_GET['pi']]['columns'][$_GET['ci']];
foreach ($column['elements'] as $ei => $elem)
    if ($elem['type'] == "image") 
        array_push($_SESSION['new_post'][$_GET['id']]['remove_media'], "img/posts/{$_GET['id']}_{$_GET['pi']}_{$_GET['ci']}_{$ei}.webp");

unset($_SESSION['new_post'][$_GET['id']]['pages'][$_GET['pi']]['columns'][$_GET['ci']]);
?>