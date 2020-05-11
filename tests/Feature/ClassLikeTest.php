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
}