<?php

  declare(strict_types=1);

	namespace Fawno\SimpleXMLExtended\Tests;

	use PHPUnit\Framework\TestCase as PHPUnitTestCase;

	class TestCase extends PHPUnitTestCase {
		public function assertFileWasCreated (string $filename, string $message = '') : void {
			$this->assertFileExists($filename, $message);

			if (is_file($filename)) {
				unlink($filename);
			}
		}
	}
