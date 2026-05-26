<?php 

class Text {
    public $strs;

    public function __construct ($strs) {
       $this->strs = $strs;
    }

    public function append ($strs) {
        foreach ($strs as $item) {
            $this->strs[] = $item;
        }
    }

    public function readData() {
        $str = "";
        foreach($this->strs as $item) {
            $str .= "<p>" . $item . "</p>";
        }
        return $str;
    }
}

?>