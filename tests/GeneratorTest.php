<?php

namespace Prizephitah\php2puml\Test;

use PhpParser\ParserFactory;
use Prizephitah\php2puml\Generator;
use PHPUnit\Framework\TestCase;

class GeneratorTest extends TestCase {
	
	public function testFromString() {
		$phpCode = <<<'EOT'
<?php
namespace Example;
class ExampleClass {
	public function run() {}
}
EOT;
		$expectedPuml = <<<'EOT'
@startuml
class Example.ExampleClass {
	run()
}
@enduml
EOT;
		
		$parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
		$generator = new Generator($parser);
		$result = $generator->fromString($phpCode);
		$this->assertEquals($expectedPuml, $result);
	}
}
