<?php


namespace Prizephitah\php2puml\Adapter;


use PhpParser\Node\Name;
use PhpParser\Node\NullableType;
use PhpParser\Node\Param;

class MethodParameter {
	
	protected Param $node;
	
	public function __construct(Param $param) {
		$this->node = $param;
	}
	
	public function getType(): string {
		if ($this->node->type instanceof Name) {
			return (string)$this->node->type->getLast();
		}
		if ($this->node->type instanceof NullableType) {
			return (string)'?'.$this->node->type->type;
		}
		return (string)$this->node->type;
	}
	
	public function getName(): string {
		return $this->node->var->name;
	}
	
	public function __toString() {
		return $this->getType().' '.$this->getName();
	}
}