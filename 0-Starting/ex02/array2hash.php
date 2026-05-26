<?php 

function array2hash(array $tab): array {
    $array = [];
    foreach ($tab as $item) {
        $array[$item[1]] = $item[0];
   }
    return $array;
}
        
// $tab = array(array("Pierre","30"), array("Mary","28"));
// print_r(array2hash($tab));
?>