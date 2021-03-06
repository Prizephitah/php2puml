<?php

namespace Prizephitah\php2puml\Test\Feature;


use Prizephitah\php2puml\Test\TestCase;

/**
 * Tests class constants, properties and methods; class-like types; visibility and modifiers.
 */
class ClassMemberTest extends TestCase {
	
	public function testClass(): void {
		$result = $this->generator->fromString(file_get_contents(__DIR__.'/TestData/Class.php'));
		$this->assertEqualStrings(file_get_contents(__DIR__.'/TestData/Class.puml'), $result);
	}
	
	public function testInterface(): void {
		$result = $this->generator->fromString(file_get_contents(__DIR__.'/TestData/Interface.php'));
		$this->assertEqualStrings(file_get_contents(__DIR__.'/TestData/Interface.puml'), $result);
	}
	
	public function testTrait(): void {
		$result = $this->generator->fromString(file_get_contents(__DIR__.'/TestData/Trait.php'));
		$this->assertEqualStrings(file_get_contents(__DIR__.'/TestData/Trait.puml'), $result);
	}
	
	public function testAbstract(): void {
		$result = $this->generator->fromString(file_get_contents(__DIR__.'/TestData/Abstract.php'));
		$this->assertEqualStrings(file_get_contents(__DIR__.'/TestData/Abstract.puml'), $result);
	}

	public function testNullableTypes(): void {
		$result = $this->generator->fromString(file_get_contents(__DIR__.'/TestData/NullableTypes.php'));
		$this->assertEqualStrings(file_get_contents(__DIR__.'/TestData/NullableTypes.puml'), $result);
	}
}