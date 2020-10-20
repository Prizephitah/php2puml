<?php

namespace Prizephitah\php2puml\Test\Generator;



use Prizephitah\php2puml\Generator\GeneratorOptions;
use Prizephitah\php2puml\Test\TestCase;

class GeneratorTest extends TestCase {
	
	public function testFromString() {
		$phpCode = <<<'EOT'
<?php
namespace Example;
class ExampleClass {
	public function run() {}
}
EOT;
		
		$result = $this->generator->fromString($phpCode);
		$this->assertIsString($result);
		$this->assertNotEmpty($result);
		$this->assertStringContainsString('@startuml', $result);
		$this->assertStringContainsString('class Example.ExampleClass', $result);
		$this->assertStringContainsString('run()', $result);
	}

	public function testNamespaceFilterPositive() {
		$phpCode = <<<'EOT'
<?php
namespace Example\Test;
class ExampleClass {
	public function run() {}
}
EOT;
		$expectedPuml = <<<'EOT'
@startuml
class Example.Test.ExampleClass {
    +run(): void
}
@enduml
EOT;
		$options = new GeneratorOptions();
		$options->namespaceFilter = 'Example\\Test';
		$result = $this->generator->fromString($phpCode, $options);
		$this->assertEqualStrings($expectedPuml, $result);
	}

	public function testNamespaceFilterNegative() {
		$phpCode = <<<'EOT'
<?php
namespace Example\Test2;
class ExampleClass {
	public function run() {}
}
EOT;
		$expectedPuml = <<<'EOT'
@startuml
@enduml
EOT;
		$options = new GeneratorOptions();
		$options->namespaceFilter = 'Example\\Test';
		$result = $this->generator->fromString($phpCode, $options);
		$this->assertEqualStrings($expectedPuml, $result);
	}

	public function testNamespaceFilterPartial() {
		$phpCode = <<<'EOT'
<?php
namespace Example\Test;
class ExampleClass {
	public function run() {}
}
EOT;
		$expectedPuml = <<<'EOT'
@startuml
class Example.Test.ExampleClass {
    +run(): void
}
@enduml
EOT;
		$options = new GeneratorOptions();
		$options->namespaceFilter = 'Example';
		$result = $this->generator->fromString($phpCode, $options);
		$this->assertEqualStrings($expectedPuml, $result);
	}

	public function testNamespaceFilterGlobalNegative() {
		$phpCode = <<<'EOT'
<?php
class ExampleClass {
	public function run() {}
}
EOT;
		$expectedPuml = <<<'EOT'
@startuml
@enduml
EOT;
		$options = new GeneratorOptions();
		$options->namespaceFilter = 'Example\\Test';
		$options->includeGlobalNamespace = false;
		$result = $this->generator->fromString($phpCode, $options);
		$this->assertEqualStrings($expectedPuml, $result);
	}

	public function testNamespaceFilterGlobalPositive() {
		$phpCode = <<<'EOT'
<?php
class ExampleClass {
	public function run() {}
}
EOT;
		$expectedPuml = <<<'EOT'
@startuml
class ExampleClass {
    +run(): void
}
@enduml
EOT;
		$options = new GeneratorOptions();
		$options->namespaceFilter = 'Example\\Test';
		$options->includeGlobalNamespace = true;
		$result = $this->generator->fromString($phpCode, $options);
		$this->assertEqualStrings($expectedPuml, $result);
	}
}
