<?php 
    require_once("TemplateEngine.php");

    $engine = new TemplateEngine();
    $coffee = new Coffee();
    $tea = new Tea();

    $engine->createFile($coffee);
    $engine->createFile($tea);
?>