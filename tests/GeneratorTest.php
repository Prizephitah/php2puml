<?php

namespace Prizephitah\php2puml\Test;

use PhpParser\ParserFactory;
use Prizephitah\php2puml\Generator;
use PHPUnit\Framework\TestCase;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

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
		$loader = new FilesystemLoader(__DIR__.'/../src/PlantUmlTemplates');
		$twig = new Environment($loader);
		
		$generator = new Generator($parser, $twig);
		$result = $generator->fromString($phpCode);
		$this->assertEqualStrings($expectedPuml, $result);
	}
	
	protected function assertEqualStrings(string $expected, $actual): void {
		$this->assertEquals(str_replace("\r\n", "\n", $expected), str_replace("\r\n", "\n", $actual));
	}
}
