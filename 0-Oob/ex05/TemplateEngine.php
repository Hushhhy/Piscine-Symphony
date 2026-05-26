<?php 

    class TemplateEngine {

        private $html;

        public function __construct(Elem $element) {
            $this->html = $element;
        }

        public function createFile($fileName) {
            $html = $this->html->getHTML();
            file_put_contents($fileName, $html);
        }

    }
?>