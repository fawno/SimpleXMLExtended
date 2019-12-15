<?php
	namespace Fawno\SimpleXMLExtended;

	class SimpleXMLExtended extends \SimpleXMLElement {
		private function addCData (string $cdata) {
			$node = dom_import_simplexml($this);
			$node->appendChild($node->ownerDocument->createCDATASection($cdata));
		}

		public function addChildCData (string $name, string $cdata = null, string $namespace = null) {
			$child = $this->addChild($name, null, $namespace);

			if (!empty($cdata)) {
				$child->addCData($cdata);
			}

			return $child;
		}

		public function formatXML (string $filename = null) {
			$xmlDocument = new \DOMDocument('1.0');
			$xmlDocument->preserveWhiteSpace = false;
			$xmlDocument->formatOutput = true;
			$xmlDocument->loadXML($this->asXML());

			if (empty($filename)) {
				return $xmlDocument->saveXML();
			} else {
				return $xmlDocument->save($filename);
			}
		}
	}
