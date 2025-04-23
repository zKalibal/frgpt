<?php

session_start();

if (($element = $_SESSION['new_post'][$_GET['id']]['pages'][$_GET['pi']]['columns'][$_GET['ci']]['elements'][$_GET['ei']])["type"] == "image") {
    array_push($_SESSION['new_post'][$_GET['id']]['remove_media'], "img/posts/{$_GET['id']}_{$_GET['pi']}_{$_GET['ci']}_{$_GET['ei']}.webp");
}

unset($_SESSION['new_post'][$_GET['id']]['pages'][$_GET['pi']]['columns'][$_GET['ci']]['elements'][$_GET['ei']]);
?>