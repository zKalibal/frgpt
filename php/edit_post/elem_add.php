<?php

session_start();
$pi = $_GET['pi'];
$ci = $_GET['ci'];

$elements = &$_SESSION['new_post'][$_GET['id']]['pages'][$pi]['columns'][$ci]['elements'];
if (!isset($elements)) $elements = []; //nel caso in cui venga salvata una colonna vuota (senza aver inserito alcun elemento), viene deletato l'array elements. Dunque bisogna ricrearlo nel momento in cui si vogliano aggiungere elementi al suo interno.
array_push(
    $elements,
    [
        "sizes" =>
        [
            "default" => "col-12"
        ],
        "type" => $_GET['type']
    ]
);

end($elements);
$ei = $last_id = key($elements);
include "templates/element.php";
