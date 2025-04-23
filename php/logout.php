<?php
include "functions.php";
session_destroy();
session_start();
$_SESSION['toasts'] = array("Account disconnesso!");
redirect("/");
