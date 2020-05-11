<?php
declare(strict_types=1);


namespace Prizephitah\php2puml\Adapter;


use PhpParser\Node\Const_;
use PhpParser\Node\Stmt\ClassConst;

class ClassConstant {
	protected ClassConst $node;
	
	public function __construct(ClassConst $classConst) {
		$this->node = $classConst;
	}
	
	public function getName(): string {
		/** @var Const_ $const */
		$const = current($this->node->consts);
		return $const->name->name;
	}
	
	public function getVisibility(): string {
		return visibilitySign($this->node);
	}
}