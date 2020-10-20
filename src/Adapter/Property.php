<?php
declare(strict_types=1);

namespace Prizephitah\php2puml\Adapter;


use PhpParser\Node\Name;
use PhpParser\Node\NullableType;
use PhpParser\Node\Stmt\PropertyProperty;

class Property {
	
	protected \PhpParser\Node\Stmt\Property $node;
	
	public function __construct(\PhpParser\Node\Stmt\Property $property) {
		$this->node = $property;
	}
	
	public function getVisibility(): string {
		return visibilitySign($this->node);
	}
	
	public function getType(): string {
		if ($this->node->type instanceof Name) {
			return (string)$this->node->type->getLast();
		}
		if ($this->node->type instanceof NullableType) {
			return (string)$this->node->type->type;
		}
		return (string)$this->node->type;
	}
	
	public function getName(): string {
		/** @var PropertyProperty $property */
		$property = current($this->node->props);
		return (string)$property->name;
	}
	
}