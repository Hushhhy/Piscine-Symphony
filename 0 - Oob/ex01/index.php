<?php 
    require_once ("TemplateEngine.php");
    require_once ("Text.php");

    $strs = [
        "Réputé pour être un tueur de monstres sans pitié, ",
        "le sorceleur Geralt est appelé dans la ville de Grimmwald. ",
        "Théâtre d'événements étranges, des bruits courent qu'un loup-garou y rôde, ",
    ];

    $engine = new TemplateEngine();
    $text = new Text($strs);

    $text->append(["tandis que l'arrivée de trois soeurs fortunées auraient transformé ", 
                "la ville pauvre en une destination touristique prisée."]);

    $engine->createFile("output.html", $text);

?>

