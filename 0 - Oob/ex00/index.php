<?php 
    require_once("TemplateEngine.php");

    $parameters = [
        "nom" => "The Witcher",
        "auteur" => "Andrzej Sapkowski",
        "description" =>    "Réputé pour être un tueur de monstres sans pitié, 
                            le sorceleur Geralt est appelé dans la ville de Grimmwald. 
                            Théâtre d'événements étranges, des bruits courent qu'un loup-garou y rôde, 
                            tandis que l'arrivée de trois soeurs fortunées auraient transformé 
                            la ville pauvre en une destination touristique prisée.",
        "prix" => "15,90",
    ];
        
    $engine = new TemplateEngine();

    $engine->createFile("output.html", "book_description.html", $parameters);

?>