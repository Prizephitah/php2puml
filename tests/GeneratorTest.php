<?php

namespace Prizephitah\php2puml\Tests;

use Prizephitah\php2puml\Generator;
use PHPUnit\Framework\TestCase;

class GeneratorTest extends TestCase {
	
	public function testFromString() {
		$phpCode = <<<'EOT'
<?php
class ExampleClass {
	public function run() {}
}
EOT;
		$expectedPuml = <<<'EOT'
@startuml
class ExampleClass {
	run()
}
@enduml
EOT;

		$generator = new Generator();
		$result = $generator->fromString($phpCode);
		$this->assertEquals($expectedPuml, $result);
	}
}
