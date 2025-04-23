<?php 
session_start();
print_r("<pre>");
print_r($_SESSION['new_post'][$_GET['id']]);
print_r("</pre>");
?>