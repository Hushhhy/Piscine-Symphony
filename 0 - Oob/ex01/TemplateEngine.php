<?php 

class TemplateEngine {

    public function createFile($fileName, $text) {
        $content = $text->readData();
        $html = "<html><body>";
        $html .= $content;
        $html .= "</body></html>";
        file_put_contents($fileName, $html);
    }
}

?>