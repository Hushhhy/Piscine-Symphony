<?php

    require_once ("Elem.php");
    require_once ("TemplateEngine.php");

    $elem = new Elem('html');
    $body = new Elem('body');
    $body->pushElement(new Elem('p', 'Lorem ipsum'));
    $elem->pushElement($body);
    $engine = new TemplateEngine($elem);
    
    $engine->createFile("elem.html");
    echo $elem->getHTML();
?>