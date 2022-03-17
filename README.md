# SimpleXMLExtended

[![GitHub license](https://img.shields.io/github/license/fawno/SimpleXMLExtended)](https://github.com/fawno/SimpleXMLExtended/blob/master/LICENSE)
[![GitHub release](https://img.shields.io/github/release/fawno/SimpleXMLExtended)](https://github.com/fawno/SimpleXMLExtended/releases)
[![Packagist](https://img.shields.io/packagist/v/fawno/simple-xml-extended)](https://packagist.org/packages/fawno/simple-xml-extended)
[![Packagist Downloads](https://img.shields.io/packagist/dt/fawno/simple-xml-extended)](https://packagist.org/packages/fawno/simple-xml-extended/stats)
[![GitHub issues](https://img.shields.io/github/issues/fawno/SimpleXMLExtended)](https://github.com/fawno/simple-xml-extended/issues)
[![GitHub forks](https://img.shields.io/github/forks/fawno/SimpleXMLExtended)](https://github.com/fawno/simple-xml-extended/network)
[![GitHub stars](https://img.shields.io/github/stars/fawno/SimpleXMLExtended)](https://github.com/fawno/simple-xml-extended/stargazers)
[![PHP](https://img.shields.io/packagist/php-v/fawno/simple-xml-extended)](https://php.net)

 SimpleXMLElement Extended class
 SimpleXMLExtended add a new method for create CData nodes.
 Also added a new method for output e nice format XML.

## Requirements
 - libxml PHP extension (enabled by default).
 - SimpleXML PHP extension (enabled by default).
 - DOM PHP extension (enabled by default).

## Installation

You can install this plugin into your application using
[composer](https://getcomposer.org):

```
  composer require fawno/simple-xml-extended
```

or, clone/download this repo, and include src/SimpleXMLExtended.php in your project.

## Usage

```php
  use Fawno\SimpleXMLExtended\SimpleXMLExtended;

  // Get a SimpleXMLExtended object from a DOM node
  $xml = simplexml_import_dom($dom, SimpleXMLExtended::class);

  // Interprets an XML file into an SimpleXMLExtended object
  $xml = simplexml_load_file($xml_file, SimpleXMLExtended::class);

  // Interprets a string of XML into an SimpleXMLExtended object
  $xml = simplexml_load_string($xml_string, SimpleXMLExtended::class);

  // Creates a new SimpleXMLExtended object
  $xml = new SimpleXMLExtended($xml_string);

  // Adds a child element to the XML node as cdata
  $xml->addChildCData('node_cdata', 'data as cdata');

  // Return a well-formed and nice formated XML string based on SimpleXMLExtended element
  $xml->formatXML()
```

## Example

```php
  require 'src/SimpleXMLExtended.php';

  use Fawno\SimpleXMLExtended\SimpleXMLExtended;

  $root = new SimpleXMLExtended('<?xml version="1.0" encoding="UTF-8"?><root/>');

  $root->addChildCData('node_cdata', 'data as cdata');

  print_r($root->asXML());
  /*
    Output:
      <?xml version="1.0" encoding="UTF-8"?>
      <root><node_cdata><![CDATA[data as cdata]]></node_cdata></root>
  */

  print_r($root->formatXML());
  /*
    Output:
      <?xml version="1.0" encoding="UTF-8"?>
      <root>
        <node_cdata><![CDATA[data as cdata]]></node_cdata>
      </root>
  */
```
