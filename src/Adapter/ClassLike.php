<?php
declare(strict_types=1);


namespace Prizephitah\php2puml\Adapter;


use phpDocumentor\Reflection\Types\Self_;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Interface_;
use PhpParser\Node\Stmt\Trait_;

class ClassLike {
	
	protected const RELATIONSHIP_ASSOCIATION = '--';
	protected const RELATIONSHIP_DEPENDENCY = '<..';
	protected const RELATIONSHIP_GENERALIZATION = '<|--';
	protected const RELATIONSHIP_REALIZATION = '<|..';
	protected const RELATIONSHIP_COMPOSITION = '*--';
	protected const RELATIONSHIP_AGGREGATION = 'o--';
	
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
	
	public function isTrait(): bool {
		return $this->node instanceof Trait_;
	}
	
	public function isAbstract(): bool {
		return $this->node instanceof Class_ && $this->node->isAbstract();
	}
	
	public function getExtends(): iterable {
		if ($this->node instanceof Class_) {
			if ($this->node->extends !== null) {
				yield self::RELATIONSHIP_GENERALIZATION => normalizeNamespacedName((string)$this->node->extends);
			}

			foreach ($this->node->implements as $implementation) {
				yield self::RELATIONSHIP_REALIZATION => normalizeNamespacedName((string)$implementation);
			}
		}
		if ($this->node instanceof Interface_) {
			foreach ($this->node->extends as $extension) {
				yield self::RELATIONSHIP_GENERALIZATION => normalizeNamespacedName((string)$extension);
			}
		}
	}
}