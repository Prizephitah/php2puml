<?php


namespace Prizephitah\php2puml\Adapter;


use PhpParser\Node\Param;

class MethodParameter {
	
	protected Param $node;
	
	public function __construct(Param $param) {
		$this->node = $param;
	}
	
	public function getType(): string {
		return (string)$this->node->type;
	}
	
	public function getName(): string {
		return $this->node->var->name;
	}
	
	public function __toString() {
		return $this->getType().' '.$this->getName();
	}
}