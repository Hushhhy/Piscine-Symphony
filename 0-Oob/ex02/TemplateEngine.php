<?php 

    require_once ("Coffee.php");
    require_once ("Tea.php");

    class TemplateEngine {

        public function createFile(HotBeverage $beverage) {
            $reflection = new ReflectionClass($beverage);
            $constants = $reflection->getConstants();
            $properties = $reflection->getProperties();
            foreach ($properties as $item) {
                $propname = $item->getName();
                $getter = "get" . ucfirst($propname);
                $data[$propname] = $beverage->$getter();
            }
            foreach ($constants as $key => $value) {
                $data[$key] = $value;
            }
            $html = file_get_contents("template.html");
            foreach ($data as $key => $value) {
                $html = str_replace("{" . $key . "}", $value, $html);
            }
            file_put_contents(get_class($beverage) . ".html", $html);
        }
    }

?>