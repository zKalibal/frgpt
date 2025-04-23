<?php

session_start();
$pages = &$_SESSION['new_post'][$_GET['id']]['pages'];
array_push(
    $pages,
    [
        "style" =>
        [
            "container" => "container",
            "vertical-margin" => "my-4"
        ],
        "columns" => array()
    ]
);

end($pages);
$pi = $last_id = key($pages);
include "templates/page.php";
