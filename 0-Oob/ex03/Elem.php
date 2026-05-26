<?php 

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

		public function __construct($element, $content = null) {
			if (!in_array($element, array_merge($this->getValid(), $this->getAuto()))) {
				echo "Invalid Element: " . $element;
				exit;
			}
			$this->elem = $element;
			$this->cont = $content;
		}

		public function pushElement($element) {
			if (!is_array($this->cont))
				$this->cont = [];
			$this->cont[] = $element;
		}

		public function getHTML() {
			if (in_array($this->elem, $this->getAuto()))
				return "<" . $this->elem . ">\n";
			$html = "<" . $this->elem . ">\n";
			if (is_array($this->cont)) {
				foreach ($this->cont as $item)
					$html .= $item->getHTML();
			}
			if (is_string($this->cont))
				$html .= $this->cont . "\n";
			$html .= "</" . $this->elem . ">\n";
			return $html;
		}
	}
?>