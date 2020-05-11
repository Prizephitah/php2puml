<?php
namespace Example;

class Animal {
	public function speak() {
	
	}
	
	public function getName(): string {
	
	}
}

class Dog extends Animal {
	
	public function speak() {
		$this->bark();
	}
	
	protected function bark() {
	
	}
}

interface Vehicle {
	public function run();
}

interface EnclosedSpace {
	public function open();
}

class Car implements Vehicle, EnclosedSpace {
	
	public function run() {
	
	}
	
	public function open() {
	
	}
}

interface A {}

interface B {}

interface C extends A,B {}