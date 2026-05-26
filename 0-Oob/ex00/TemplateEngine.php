<?php 

class TemplateEngine {

    public function createFile($fileName, $templateName, $parameters) {
        $content = file_get_contents($templateName);
        foreach ($parameters as $key => $value) {
            $content = str_replace("{" . $key . "}", $value, $content);
        }
        file_put_contents($fileName, $content);
    }
}

?>