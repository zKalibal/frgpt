<?php

include "functions.php";
if ($_POST['body'] == "")
    unset($_SESSION['modal']);
else
    $_SESSION['modal'] = array("title" => $_GET['title'], "body" => $_POST['body'], "get" => $_GET['get'], "size" => $_GET['size']);
?>