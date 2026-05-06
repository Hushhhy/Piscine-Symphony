<?php

function array2hash_sorted(array $tab) : array {
    $array = [];
    foreach ($tab as $item) {
        $array[$item[0]] = $item[1];
    }
    krsort($array);
    return $array;
}

// $array = array(array("Pierre","30"), array("Mary","28"), array("Nelly", "22"));
// print_r ( array2hash_sorted($array) );

?>