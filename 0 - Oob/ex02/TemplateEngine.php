<?php 

    require_once ("Coffee.php");
    require_once ("Tea.php");

    class TemplateEngine {

        public function createFile(HotBeverage $text) {
            $reflection = new ReflectionClass($text);
            $constants = $reflection->getConstants();
            $properties = $reflection->getProperties();
            foreach ($properties as $item) {
                $description = $item->getName();
                $getter = "get" . ucfirst($description);
                $data[$description] = $text->$getter();
            }
            foreach ($constants as $key => $value) {
                $data[$key] = $value;
            }
            $html = file_get_contents("template.html");
            foreach ($data as $key => $value) {
                $html = str_replace("{" . $key . "}", $value, $html);
            }
            file_put_contents(get_class($text) . ".html", $html);
        }
    }

?>