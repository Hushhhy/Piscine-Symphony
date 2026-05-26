<?php
    require_once("TemplateEngine.php");

    $engine = new TemplateEngine();

    // Test 1 : génération du fichier Coffee.html
    echo "=== Test 1 : Coffee ===\n";
    $coffee = new Coffee();
    $engine->createFile($coffee);
    echo "Coffee.html généré\n";
    echo "Nom : " . $coffee->getName() . "\n";
    echo "Prix : " . $coffee->getPrice() . "\n";
    echo "Résistance : " . $coffee->getResistence() . "\n";

    // Test 2 : génération du fichier Tea.html
    echo "=== Test 2 : Tea ===\n";
    $tea = new Tea();
    $engine->createFile($tea);
    echo "Tea.html généré\n";
    echo "Nom : " . $tea->getName() . "\n";
    echo "Prix : " . $tea->getPrice() . "\n";
    echo "Résistance : " . $tea->getResistence() . "\n";

    // Test 3 : getters description et comment
    echo "=== Test 3 : getters privés ===\n";
    echo "Coffee description : " . $coffee->getDescription() . "\n";
    echo "Coffee comment : " . $coffee->getComment() . "\n";
    echo "Tea comment : " . $tea->getComment() . "\n";
?>