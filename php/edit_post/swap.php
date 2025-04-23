<?php

session_start();
$pi = $_GET['pi'];
$ci = $_GET['ci'];
$ei = $_GET['ei'];
$dir = $_GET['dir'];

if ($ci == "") {
    $i = $pi;
    $array = &$_SESSION['new_post'][$_GET['id']]['pages'];
} else if ($ei == "") {
    $i = $ci;
    $array = &$_SESSION['new_post'][$_GET['id']]['pages'][$pi]['columns'];
} else {
    $i = $ei;
    $array = &$_SESSION['new_post'][$_GET['id']]['pages'][$pi]['columns'][$ci]['elements'];
}

function array_swap_assoc($key1, $key2, $array) {
    $newArray = array();
    foreach ($array as $key => $value) {
        if ($key == $key1) {
            $newArray[$key2] = $array[$key2];
        } elseif ($key == $key2) {
            $newArray[$key1] = $array[$key1];
        } else {
            $newArray[$key] = $value;
        }
    }
    return $newArray;
}

if ($dir == "up") {
    $keys = array_keys($array);
    $swap = $keys[array_search($i, $keys) - 1];
} else
if ($dir == "down") {
    $keys = array_keys($array);
    $swap = $keys[array_search($i, $keys) + 1];
}

if (is_numeric($swap)) {
    $array = array_swap_assoc($i, $swap, $array);

    if ($ci == "") {
        foreach ($_SESSION['new_post'][$_GET['id']]['pages'] as $pi => $p) {
            include "templates/page.php";
        }
    } else if ($ei == "")
        include "templates/page.php";
    else
        include "templates/column.php";
}
?>