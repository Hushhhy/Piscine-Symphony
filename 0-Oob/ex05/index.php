<?php

    require_once ("Elem.php");
    require_once ("TemplateEngine.php");

    // Test 1 : validPage() valide - page correcte
    echo "=== Test 1 : validPage() true ===\n";
    $page = new Elem('html');
    $head = new Elem('head');
    $head->pushElement(new Elem('title', 'Ma page'));
    $head->pushElement(new Elem('meta', null, ['charset' => 'utf-8']));
    $body = new Elem('body');
    $body->pushElement(new Elem('p', 'Bonjour'));
    $page->pushElement($head);
    $page->pushElement($body);
    $engine = new TemplateEngine($page);
    $engine->createFile("test1.html");
    echo $page->validPage() ? "true\n" : "false\n";

    // Test 2 : validPage() false - racine pas html
    echo "=== Test 2 : racine pas html ===\n";
    $page = new Elem('div');
    $engine = new TemplateEngine($page);
    $engine->createFile("test2.html");
    echo $page->validPage() ? "true\n" : "false\n";

    // Test 3 : validPage() false - head sans meta charset
    echo "=== Test 3 : head sans meta charset ===\n";
    $page = new Elem('html');
    $head = new Elem('head');
    $head->pushElement(new Elem('title', 'Ma page'));
    $body = new Elem('body');
    $page->pushElement($head);
    $page->pushElement($body);
    $engine = new TemplateEngine($page);
    $engine->createFile("test3.html");
    echo $page->validPage() ? "true\n" : "false\n";

    // Test 4 : validPage() false - p contient un tag
    echo "=== Test 4 : p contient un tag ===\n";
    $page = new Elem('html');
    $head = new Elem('head');
    $head->pushElement(new Elem('title', 'Ma page'));
    $head->pushElement(new Elem('meta', null, ['charset' => 'utf-8']));
    $body = new Elem('body');
    $p = new Elem('p');
    $p->pushElement(new Elem('span', 'texte'));
    $body->pushElement($p);
    $page->pushElement($head);
    $page->pushElement($body);
    $engine = new TemplateEngine($page);
    $engine->createFile("test4.html");
    echo $page->validPage() ? "true\n" : "false\n";

    // Test 5 : validPage() false - table avec enfant non-tr
    echo "=== Test 5 : table avec enfant non-tr ===\n";
    $page = new Elem('html');
    $head = new Elem('head');
    $head->pushElement(new Elem('title', 'Ma page'));
    $head->pushElement(new Elem('meta', null, ['charset' => 'utf-8']));
    $body = new Elem('body');
    $table = new Elem('table');
    $table->pushElement(new Elem('td', 'cell'));
    $body->pushElement($table);
    $page->pushElement($head);
    $page->pushElement($body);
    $engine = new TemplateEngine($page);
    $engine->createFile("test5.html");
    echo $page->validPage() ? "true\n" : "false\n";

    // Test 6 : validPage() false - ul avec enfant non-li
    echo "=== Test 6 : ul avec enfant non-li ===\n";
    $page = new Elem('html');
    $head = new Elem('head');
    $head->pushElement(new Elem('title', 'Ma page'));
    $head->pushElement(new Elem('meta', null, ['charset' => 'utf-8']));
    $body = new Elem('body');
    $ul = new Elem('ul');
    $ul->pushElement(new Elem('p', 'pas un li'));
    $body->pushElement($ul);
    $page->pushElement($head);
    $page->pushElement($body);
    $engine = new TemplateEngine($page);
    $engine->createFile("test6.html");
    echo $page->validPage() ? "true\n" : "false\n";
?>