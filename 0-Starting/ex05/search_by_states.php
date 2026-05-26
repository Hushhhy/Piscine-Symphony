<?php

function search_by_states(string $str) : array {
    global $states, $capitals;
    $val = explode(",", $str);
    $results = [];

    foreach($val as $item) {
        $trim_item = trim($item);
        if (array_key_exists($trim_item, $states)) {
            $abr = $states[$trim_item];
            if (array_key_exists($abr, $capitals))
                $results[] = $capitals[$abr] . " is the capital of " . $trim_item . ".";
            else
                $results[] = $trim_item . " is neither a capital nor a state.";
        }
        else if (array_search($trim_item, $capitals) !== false) {
            $abr = array_search($trim_item, $capitals);
            if (array_search($abr, $states) !== false) {
                $state = array_search($abr, $states);
                $results[] = $trim_item . " is the capital of " . $state . ".";
            }
            else
                $results[] = $trim_item . " is neither a capital nor a state.";
        }
        else
            $results[] = $trim_item . " is neither a capital nor a state.";
    }
    return $results;
}

// $states = [
//     'Oregon' => 'OR',
//     'Alabama' => 'AL',
//     'New Jersey' => 'NJ',
//     'Colorado' => 'CO',
//     'Paname' => "PA",
// ];
// $capitals = [
//     'OR' => 'Salem',
//     'AL' => 'Montgomery',
//     'NJ' => 'trenton',
//     'KS' => 'Topeka',
// ];

// $results = search_by_states("Oregon, trenton, Topeka, NewJersey, Paname");

// foreach ($results as $result) {
//     echo $result . "\n";
// }

?>