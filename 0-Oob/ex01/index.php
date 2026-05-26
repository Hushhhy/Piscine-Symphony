<?php
    require_once ("TemplateEngine.php");
    require_once ("Text.php");

    $engine = new TemplateEngine();

    // Test 1 : construction avec tableau initial + readData
    echo "=== Test 1 : readData sur tableau initial ===\n";
    $text = new Text(["Ligne 1", "Ligne 2", "Ligne 3"]);
    echo $text->readData() . "\n";

    // Test 2 : append ajoute bien les nouvelles strings
    echo "=== Test 2 : append puis readData ===\n";
    $text->append(["Ligne 4", "Ligne 5"]);
    echo $text->readData() . "\n";

    // Test 3 : createFile génère un fichier HTML valide
    echo "=== Test 3 : createFile ===\n";
    $text2 = new Text(["Le sorceleur Geralt est un tueur de monstres."]);
    $text2->append(["Il voyage à travers le continent.", "Il recherche son destin."]);
    $engine->createFile("output.html", $text2);
    echo "output.html généré\n";

    // Test 4 : tableau vide
    echo "=== Test 4 : tableau vide ===\n";
    $text3 = new Text([]);
    echo "readData vide : '" . $text3->readData() . "'\n";
?>