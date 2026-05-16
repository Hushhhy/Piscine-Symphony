<?php

    require_once ("Elem.php");
    require_once ("TemplateEngine.php");

    // Test 1 : exemple de l'énoncé
    echo "=== Test 1 : exemple enonce ===\n";
    $elem = new Elem('html');
    $body = new Elem('body');
    $engine = new TemplateEngine($elem);
    $body->pushElement(new Elem('p', 'Lorem ipsum', ['class' => 'text-muted']));
    $elem->pushElement($body);
    $engine->createFile("test1.html");
    echo $elem->getHTML();

    // Test 2 : plusieurs attributs sur un même tag
    echo "=== Test 2 : plusieurs attributs ===\n";
    $div = new Elem('div', 'contenu', ['class' => 'box', 'id' => 'main']);
    $engine = new TemplateEngine($div);
    $engine->createFile("test2.html");
    echo $div->getHTML();

    // Test 3 : tag sans attributs ni contenu
    echo "=== Test 3 : tag vide sans attributs ===\n";
    $span = new Elem('span');
    $engine = new TemplateEngine($span);
    $engine->createFile("test3.html");
    echo $span->getHTML();

    // Test 4 : nouveaux tags (ul, li)
    echo "=== Test 4 : nouveaux tags ===\n";
    $ul = new Elem('ul');
    $ul->pushElement(new Elem('li', 'item 1'));
    $ul->pushElement(new Elem('li', 'item 2'));
    $engine = new TemplateEngine($ul);
    $engine->createFile("test4.html");
    echo $ul->getHTML();

    // Test 5 : tag auto-fermant (pas d'attributs rendus, pas de fermeture)
    echo "=== Test 5 : tag auto-fermant ===\n";
    $br = new Elem('br');
    $engine = new TemplateEngine($br);
    $engine->createFile("test5.html");
    echo $br->getHTML();

    // Test 6 : tag invalide -> doit lancer MyException
    echo "=== Test 6 : tag invalide ===\n";
    try {
        $bad = new Elem('undefined');
        $engine = new TemplateEngine($bad);
        $engine->createFile("test6.html");
    } catch (MyException $e) {
        echo "MyException attrapee : " . $e->getMessage() . "\n";
    }
?>