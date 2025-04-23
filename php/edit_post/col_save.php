<?php

session_start();

$pi = $_GET['pi'];
$ci = $_GET['ci'];

$column = &$_SESSION['new_post'][$_GET['id']]['pages'][$pi]['columns'][$ci];
$column["style"] = $_POST['style'];
$column["sizes"] = $_POST['sizes'];

include("templates/column.php");
?>