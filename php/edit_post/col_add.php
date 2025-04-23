<?php

session_start();
$pi = $_GET['pi'];

$columns = &$_SESSION['new_post'][$_GET['id']]['pages'][$pi]['columns'];
array_push(
    $columns,
    [
        "style" => [
            "vertical-align" => "align-content-start",
            "vertical-gap" => "gy-4",
            "horizontal-gap" => "gx-4"

        ],
        "sizes" => [
            "default" => "col"
        ],
        "elements" => array()
    ]
);

end($columns);
$ci = $last_id = key($columns);
include "templates/column.php";
