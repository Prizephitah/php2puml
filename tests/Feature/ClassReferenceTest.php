<?php

namespace Prizephitah\php2puml\Test\Feature;


use Prizephitah\php2puml\Test\TestCase;

/**
 * Tests class inheritance.
 */
class ClassReferenceTest extends TestCase {
	
	public function testInheritance(): void {
		$result = $this->generator->fromString(file_get_contents(__DIR__.'/TestData/Inheritance.php'));
		$this->assertEqualStrings(file_get_contents(__DIR__.'/TestData/Inheritance.puml'), $result);
	}

}
