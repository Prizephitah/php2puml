<?php

namespace Prizephitah\php2puml\Test\Feature;


use Prizephitah\php2puml\Test\TestCase;

class ClassLikeTest extends TestCase {
	
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
}