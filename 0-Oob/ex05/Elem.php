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

		public function isList($list) {
			foreach ($list as $item) {
				if ($item->elem !== "li")
					return false;
			}
			return true;
		}

		public function isTable($table) {
			foreach ($table as $item) {
				if ($item->elem !== "tr")
					return false;
				if (!is_array($item->cont))
					return true;
				foreach ($item->cont as $item) {
					if ($item->elem !== "th" &&  $item->elem !== "td")
						return false;
				}
			}
			return true;
		}

		public function checkChildren($child) {
			if ($child->elem === "p" && !is_string($child->cont))
				return false;
			if ($child->elem === "table") {
				if (!$this->isTable($child->cont))
					return false;
			}
			if ($child->elem === "ul" || $child->elem === "ol") {
				if (!$this->isList($child->cont))
					return false;
			}
			if ($child->elem === "li" || $child->elem === "tr" || $child->elem === "th" || $child->elem === "td")
				return false;
			if ($child->elem === "div") {
				if (!is_array($child->cont))
					return true;
				foreach ($child->cont as $subChild) {
					if (!$this->checkChildren($subChild))
						return false;
				}
			}
			return true;
		}

		public function validElem() {
			$body = $this->cont[1]->cont;
			if (!is_array($body))
				return true;
			foreach ($body as $item) {
				if (!$this->checkChildren($item))
					return false;
			}
			return true;
		}

		public function validNode() {
			$head = $this->cont[0]->cont;
			if (!is_array($head) || count($head) !== 2)
				return false;
			$titles = count(array_filter($this->cont[0]->cont, fn($item) => $item->elem === "title"));
			$meta = count(array_filter($this->cont[0]->cont, fn($item) => $item->elem === "meta" && isset($item->att['charset'])));
			if ($titles !== 1 || $meta !== 1)
				return false;
			return true;
		}

		public function validPage() {
			if ($this->elem !== "html" || !is_array($this->cont) || count($this->cont) !== 2)
				return false;
			if ($this->cont[0]->elem !== "head" || $this->cont[1]->elem !== "body")
				return false;
			if (!$this->validNode() || !$this->validElem())
				return false;
			return true;
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