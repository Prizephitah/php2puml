<?php

namespace Prizephitah\php2puml\Test;



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
		
		$result = $this->generator->fromString($phpCode);
		$this->assertIsString($result);
		$this->assertNotEmpty($result);
		$this->assertStringContainsString('@startuml', $result);
		$this->assertStringContainsString('class Example.ExampleClass', $result);
		$this->assertStringContainsString('run()', $result);
	}
}
