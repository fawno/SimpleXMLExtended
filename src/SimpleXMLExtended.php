<?php
	declare(strict_types=1);

	namespace Fawno\SimpleXMLExtended;

	use SimpleXMLElement;
	use DOMDocument;
	use DOMNode;
	use Exception;
	use DOMException;

	class SimpleXMLExtended extends SimpleXMLElement {
		public static function importDOM (DOMNode $node, string $class_name = SimpleXMLExtended::class) : ?SimpleXMLElement {
			return simplexml_import_dom($node, $class_name);
		}

		public static function loadFile (string $filename, string $class_name = SimpleXMLExtended::class, int $options = 0, string $ns = '', bool $is_prefix = false) : SimpleXMLElement|false {
			return simplexml_load_file($filename, $class_name, $options, $ns, $is_prefix);
		}

		public static function loadXML (string $data, string $class_name = SimpleXMLExtended::class, int $options = 0, string $ns = '', bool $is_prefix = false) : SimpleXMLElement|false {
			return simplexml_load_string($data, $class_name, $options, $ns, $is_prefix);
		}

		public static function loadHTML (string $data, string $class_name = SimpleXMLExtended::class, int $options = 0) : ?SimpleXMLElement {
			$node = new DOMDocument();

			if (false === @$node->loadHTML($data, $options)) {
				return null;
			}

			return simplexml_import_dom($node, $class_name);
		}

		private function addCData (string $cdata) : void {
			$node = dom_import_simplexml($this);
			$node->appendChild($node->ownerDocument->createCDATASection($cdata));
		}

		public function addChildCData (string $name, string $cdata = null, string $namespace = null) : ?SimpleXMLElement {
			$child = $this->addChild($name, null, $namespace);

			if (!empty($cdata)) {
				$child->addCData($cdata);
			}

			return $child;
		}

		public function parentNode () : ?SimpleXMLExtended {
			return simplexml_import_dom(dom_import_simplexml($this)->parentNode, SimpleXMLExtended::class);
		}

		public function removeNode () : ?SimpleXMLExtended {
			return $this->parentNode()->removeChild($this);
		}

		public function removeChild (SimpleXMLExtended $oldnode) : ?SimpleXMLExtended {
			try {
				$removed = dom_import_simplexml($this)->removeChild(dom_import_simplexml($oldnode));
			} catch (Exception | DOMException $e) {
				return null;
			}

			return $oldnode;
		}

		public function asText (bool $strip_spaces = false) : ?string {
			$text = strip_tags($this->asXML());
			$text = $strip_spaces ? trim(preg_replace('~\s+~', ' ', $text)) : $text;

			return ($text ?: null);
		}

		public function formatXML (string $filename = null) : string|int|false {
			$xmlDocument = new DOMDocument('1.0');
			$xmlDocument->preserveWhiteSpace = false;
			$xmlDocument->formatOutput = true;

			if (false === $xmlDocument->loadXML($this->asXML())) {
				return false;
			}

			if (empty($filename)) {
				return $xmlDocument->saveXML();
			}

			return $xmlDocument->save($filename);
		}
	}
