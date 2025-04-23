<?php

session_start();
$page = &$_SESSION['new_post'][$_GET['id']]['pages'][$_GET['pi']];
foreach ($page['columns'] as $ci => $col)
    foreach ($col['elements'] as $ei => $elem)
        if ($elem['type'] == "image") 
            array_push($_SESSION['new_post'][$_GET['id']]['remove_media'], "img/posts/{$_GET['id']}_{$_GET['pi']}_{$ci}_{$ei}.webp");

unset($_SESSION['new_post'][$_GET['id']]['pages'][$_GET['pi']]);
