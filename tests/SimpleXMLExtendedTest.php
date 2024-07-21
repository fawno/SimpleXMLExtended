<?php
  declare(strict_types=1);

	namespace Fawno\SimpleXMLExtended\Tests;

	use Fawno\SimpleXMLExtended\SimpleXMLExtended;
	use Fawno\SimpleXMLExtended\Tests\TestCase;

	class SimpleXMLExtendedTest extends TestCase {
		const EXAMPLE_VOIDFILE = __DIR__ . '/examples/void.xml';
		const EXAMPLE_HTMLSTR = <<<HTM
<movies>
 <movie>
  <title>PHP: Behind the Parser</title>
  <characters>
   <character>
    <name>Ms. Coder</name>
    <actor>Onlivia Actora</actor>
   </character>
   <character>
    <name>Mr. Coder</name>
    <actor>El Actor</actor>
   </character>
  </characters>
  <plot>
   So, this language. It's like, a programming language. Or is it a
   scripting language? All is revealed in this thrilling horror spoof
   of a documentary.
  </plot>
  <great-lines>
   <line>PHP solves all my web problems</line>
  </great-lines>
  <rating type="thumbs">7</rating>
  <rating type="stars">5</rating>
 </movie>
</movies>
HTM;
		const EXAMPLE_XMLFILE = __DIR__ . '/examples/example.xml';
		const EXAMPLE_XMLSTR = <<<XML
<?xml version='1.0' standalone='yes'?>
<movies>
 <movie>
  <title>PHP: Behind the Parser</title>
  <characters>
   <character>
    <name>Ms. Coder</name>
    <actor>Onlivia Actora</actor>
   </character>
   <character>
    <name>Mr. Coder</name>
    <actor>El Actor</actor>
   </character>
  </characters>
  <plot>
   So, this language. It's like, a programming language. Or is it a
   scripting language? All is revealed in this thrilling horror spoof
   of a documentary.
  </plot>
  <great-lines>
   <line>PHP solves all my web problems</line>
  </great-lines>
  <rating type="thumbs">7</rating>
  <rating type="stars">5</rating>
 </movie>
</movies>
XML;

		protected function setUp () : void {
			if (!is_file(self::EXAMPLE_VOIDFILE)) {
				touch(self::EXAMPLE_VOIDFILE);
			}

			if (!is_file(self::EXAMPLE_XMLFILE)) {
				file_put_contents(self::EXAMPLE_XMLFILE, self::EXAMPLE_XMLSTR);
			}
		}

		public function testLoadFile () {
			$xml = SimpleXMLExtended::loadFile(self::EXAMPLE_XMLFILE);
			$this->assertInstanceOf(SimpleXMLExtended::class, $xml);
			$this->assertXmlStringEqualsXmlString(self::EXAMPLE_XMLSTR, $xml->asXML());
		}

		public function testLoadXML () {
			$xml = SimpleXMLExtended::loadXML(self::EXAMPLE_XMLSTR);
			$this->assertInstanceOf(SimpleXMLExtended::class, $xml);
			$this->assertXmlStringEqualsXmlString(self::EXAMPLE_XMLSTR, $xml->asXML());
		}

		public function testLoadHTML () {
			$xml = SimpleXMLExtended::loadHTML(self::EXAMPLE_HTMLSTR);
			$this->assertInstanceOf(SimpleXMLExtended::class, $xml);
			$this->assertXmlStringEqualsXmlString(self::EXAMPLE_XMLSTR, $xml->body->movies->asXML());
		}

		public function testRemove () {
			$xml = SimpleXMLExtended::loadXML(self::EXAMPLE_XMLSTR);
			$xml->movie->removeNode();
			$expected = SimpleXMLExtended::loadXML('<?xml version="1.0"?><movies>&#xA;&#032;&#xA;</movies>');
			$this->assertXmlStringEqualsXmlString($expected->asXML(), $xml->asXML());
		}
	}
