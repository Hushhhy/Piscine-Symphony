<?php
    require_once ("Elem.php");
    require_once ("TemplateEngine.php");

    // Test 1 : exemple de l'énoncé
    echo "=== Test 1 : exemple énoncé ===\n";
    $elem = new Elem('html');
    $body = new Elem('body');
    $body->pushElement(new Elem('p', 'Lorem ipsum'));
    $elem->pushElement($body);
    echo $elem->getHTML();
    $engine = new TemplateEngine($elem);
    $engine->createFile("test1.html");

    // Test 2 : tag auto-fermant
    echo "=== Test 2 : tags auto-fermants ===\n";
    $page = new Elem('html');
    $page->pushElement(new Elem('br'));
    $page->pushElement(new Elem('hr'));
    echo $page->getHTML();

    // Test 3 : structure imbriquée
    echo "=== Test 3 : structure imbriquée ===\n";
    $html = new Elem('html');
    $head = new Elem('head');
    $head->pushElement(new Elem('title', 'Ma page'));
    $body = new Elem('body');
    $body->pushElement(new Elem('h1', 'Titre principal'));
    $body->pushElement(new Elem('p', 'Premier paragraphe'));
    $body->pushElement(new Elem('p', 'Deuxième paragraphe'));
    $html->pushElement($head);
    $html->pushElement($body);
    echo $html->getHTML();
    $engine2 = new TemplateEngine($html);
    $engine2->createFile("test4.html");

    // Test 4 : tag invalide affiche message et quitte
    echo "=== Test 4 : tag invalide ===\n";
    $bad = new Elem('brr');
?>