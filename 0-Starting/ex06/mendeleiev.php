<?php 
    ob_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mendeleiev Table</title>
    <style>
        body { background: #1a1a2e; font-family: Arial, sans-serif; margin: 0; padding: 20px; }
        h1 { color: #eee; text-align: center; margin-bottom: 20px; }
        table { border-collapse: separate; border-spacing: 3px; }
        td {
            width: 68px; height: 68px;
            padding: 15px; vertical-align: top;
            border-radius: 4px; font-size: 10px;
            color: #111; border: 1px solid rgba(0,0,0,0.2);
        }
        td h4 { margin: 0 0 2px; font-size: 12px; font-weight: bold; }
        td ul { margin: 0; padding: 0; list-style: none; font-size: 9px; }
        td:empty { background: transparent; border: none; }
        .hydrogen       { background: #a0e7e5; }
        .noble-gas      { background: #c0ffff; }
        .alkali-metal   { background: #ff6666; }
        .alkaline-earth { background: #ffdead; }
        .transition     { background: #ffc0c0; }
        .lanthanide     { background: #ffbfff; }
        .actinide       { background: #ff99cc; }
        .metalloid      { background: #cccc99; }
        .nonmetal       { background: #a0ffa0; }
        .halogen        { background: #ffff99; }
        .post-transition{ background: #cccccc; }
    </style>
</head>
<body> 
<?php
    $elements = [];
    $rows = [];
    $txt = file_get_contents("ex06.txt");
    $lines = explode("\n", trim($txt));
    foreach ($lines as $line) {
        $parts = explode("=", $line);
        $name = trim($parts[0]);
        $attributes = explode(",", $parts[1]);
        $element = ["name" => $name];
        foreach ($attributes as $attr) {
            $kval = explode(":", $attr);
            $key = trim($kval[0]);
            $value = trim($kval[1]);
            $element[$key] = $value;
        }
        $elements[] = $element;
        // print_r($elements);
    }

    foreach ($elements as $element) {
        $number = (int)$element["number"];
        if ($number <= 2) $row = 0;
        else if ($number <= 10) $row = 1;
        else if ($number <= 18) $row = 2;
        else if ($number <= 36) $row = 3;
        else if ($number <= 54) $row = 4;
        else if ($number <= 86) $row = 5;
        else $row = 6;
        $rows[$row][$element["position"]] = $element;
    }
    // print_r($rows);

    ?>
    <?php
    function getElementClass(int $n): string {
        if ($n === 1) return 'hydrogen';
        if (in_array($n, [2,10,18,36,54,86,118])) return 'noble-gas';
        if (in_array($n, [3,11,19,37,55,87])) return 'alkali-metal';
        if (in_array($n, [4,12,20,38,56,88])) return 'alkaline-earth';
        if (($n >= 21 && $n <= 30) || ($n >= 39 && $n <= 48) || ($n >= 72 && $n <= 80) || ($n >= 104 && $n <= 112)) return 'transition';
        if ($n >= 57 && $n <= 71) return 'lanthanide';
        if ($n >= 89 && $n <= 103) return 'actinide';
        if (in_array($n, [5,14,32,33,51,52,84])) return 'metalloid';
        if (in_array($n, [6,7,8,15,16,34])) return 'nonmetal';
        if (in_array($n, [9,17,35,53,85,117])) return 'halogen';
        return 'post-transition';
    }
    ?>
    <h1>Periodic Table of Elements</h1>
    <table>
        <?php for ($r = 0; $r <= 6; $r++): ?>
            <tr>
                <?php for ($col = 0; $col <= 17; $col++): ?>
                    <?php if (isset($rows[$r][$col])): ?>
                        <?php $el = $rows[$r][$col]; ?>
                        <td class="<?= getElementClass((int)$el['number']) ?>">
                            <h4><?= $el["name"] ?></h4>
                            <ul>
                                <?php foreach ($el as $key => $val): ?>
                                    <?php if ($key !== "name"): ?>
                                        <li><?= $key ?>: <?= $val ?></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>    
                            </ul>
                        </td>
                    <?php else: ?>
                        <td></td>
                    <?php endif; ?>
                <?php endfor; ?>
            </tr>
        <?php endfor; ?>
    </table>
</body>
</html>
<!-- LAUNCH = php -S localhost:8000 -> http://localhost:8000/ex06/mendeleiev.html -->
<?php
    $html = ob_get_clean();
    file_put_contents("mendeleiev.html", $html);
?>