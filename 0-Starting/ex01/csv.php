<?php
    $txt = trim(file_get_contents("ex01.txt"));
    $val = explode(",", $txt);
    foreach ($val as $item) {
        echo $item . "\n";
    }
?>
