<?php 
    require_once ("MyException.php");
	class Elem {
		const valid = [
		"html",
		"head",
		"body",
		"title",
		"h1",
		"h2",
		"h3",
		"h4",
		"h5",
		"h6",
		"p",
		"span",
		"div",
        "table",
        "tr",
        "th",
        "td",
        "ul",
        "ol",
        "li"
		];

		const auto = [
			"br",
			"hr",
			"meta",
			"img",
		];

		public function getValid() {
			return self::valid;
		}

		public function getAuto() {
			return self::auto;
		}

		public $elem;
		public $cont;
        public $att;

		public function __construct($element, $content = null, $attributes = []) {
			if (!in_array($element, array_merge($this->getValid(), $this->getAuto()))) {
				throw new MyException("Invalid Element: " . $element);
			}
			$this->elem = $element;
			$this->cont = $content;
            $this->att = $attributes;
		}

		public function pushElement($element) {
			if (!is_array($this->cont))
				$this->cont = [];
			$this->cont[] = $element;
		}

		public function getHTML() {
            $attrs = "";
            foreach ($this->att as $key => $value)
                $attrs .= $key . '="' . $value . '" '; 
			if (in_array($this->elem, $this->getAuto()))
				return "<" . $this->elem . ($attrs ? " " . $attrs : "") . ">\n";
            $html = "<" . $this->elem . ($attrs ? " " . $attrs : "") . ">\n";
			if (is_array($this->cont)) {
				foreach ($this->cont as $item) {
                    $html .= $item->getHTML();
                }
			}
			if (is_string($this->cont))
				$html .= $this->cont . "\n";
			$html .= "</" . $this->elem . ">\n";
			return $html;
		}
	}
?>