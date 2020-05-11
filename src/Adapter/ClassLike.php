<?php
declare(strict_types=1);


namespace Prizephitah\php2puml\Adapter;


use PhpParser\Node\Stmt\Interface_;
use PhpParser\Node\Stmt\Trait_;

class ClassLike {
	
	protected \PhpParser\Node\Stmt\ClassLike $node;
	
	public function __construct(\PhpParser\Node\Stmt\ClassLike $classLike) {
		$this->node = $classLike;
	}
	
	public function getName(): string {
		return strtr((string)$this->node->namespacedName, '\\', '.');
	}
	
	public function getType(): string {
		switch (get_class($this->node)) {
			case Interface_::class:
				return 'interface';
				break;
			case Trait_::class:
				return 'trait';
				break;
			default:
				return 'class';
		}
	}
	
	/**
	 * @return ClassConstant[]|\Generator
	 */
	public function getConstants(): iterable {
		foreach ($this->node->getConstants() as $constant) {
			yield new ClassConstant($constant);
		}
	}
	
	public function getProperties(): iterable {
		foreach ($this->node->getProperties() as $property) {
			yield new Property($property);
		}
	}
	
	public function getMethods(): iterable {
		foreach ($this->node->getMethods() as $method) {
			yield new Method($method);
		}
	}
}