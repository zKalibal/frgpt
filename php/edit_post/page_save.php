<?php

session_start();

$pi = $_GET['pi'];

$_SESSION['new_post'][$_GET['id']]['pages'][$pi]["style"] = $_POST['style'];

include("templates/page.php");
?>