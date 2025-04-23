<?php

session_start();

$pi = $_GET['pi'];
$ci = $_GET['ci'];
$ei = $_GET['ei'];

$element = &$_SESSION['new_post'][$_GET['id']]['pages'][$pi]['columns'][$ci]['elements'][$ei];
$element["style"] = $_POST['style'];
$element["sizes"] = $_POST['sizes'];

if ($element["type"] == "text" || $element["type"] == "video" || $element["type"] == "html") {
    $element["content"] = $_POST['content'];
} 

include("templates/element.php");
