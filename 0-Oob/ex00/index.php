<?php
    require_once("TemplateEngine.php");

    $engine = new TemplateEngine();

    // Test 1 : génération normale avec tous les paramètres
    echo "=== Test 1 : génération normale ===\n";
    $parameters = [
        "nom" => "The Witcher",
        "auteur" => "Andrzej Sapkowski",
        "description" => "Réputé pour être un tueur de monstres sans pitié, le sorceleur Geralt est appelé dans la ville de Grimmwald.",
        "prix" => "15,90",
    ];
    $engine->createFile("test1.html", "book_description.html", $parameters);
    echo "output1.html généré\n";

    // Test 2 : paramètres différents, même template
    echo "=== Test 2 : autre livre ===\n";
    $parameters2 = [
        "nom" => "Harry Potter",
        "auteur" => "J.K. Rowling",
        "description" => "Un jeune garçon découvre qu'il est un sorcier et rejoint l'école de magie Poudlard.",
        "prix" => "12,50",
    ];
    $engine->createFile("test2.html", "book_description.html", $parameters2);
    echo "output2.html généré\n";
?>
