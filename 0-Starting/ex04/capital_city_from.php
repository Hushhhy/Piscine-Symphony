<?php 

function capital_city_from(string $str) : string {
    global $states, $capitals;
    if (array_key_exists($str, $states)) {
        $abr = $states[$str];
        return $capitals[$abr];
    }
    return "Unknown";
}

// $states = [
//     'Oregon' => 'OR',
//     'Alabama' => 'AL',
//     'New Jersey' => 'NJ',
//     'Colorado' => 'CO',
// ];
// $capitals = [
//     'OR' => 'Salem',
//     'AL' => 'Montgomery',
//     'NJ' => 'trenton',
//     'KS' => 'Topeka',
// ];

// echo capital_city_from('Oregon') . "\n";
// echo capital_city_from('Origan') . "\n";

?>