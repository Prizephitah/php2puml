<?php
declare(strict_types=1);

namespace Prizephitah\php2puml\Adapter;


use PhpParser\Node\NullableType;
use PhpParser\Node\Stmt\ClassMethod;

class Method {
	
	protected ClassMethod $node;
	
	public function __construct(ClassMethod $classMethod) {
		$this->node = $classMethod;
	}
	
	public function getVisibility(): string {
		return visibilitySign($this->node);
	}
	
	public function getName(): string {
		return (string)$this->node->name;
	}
	
	public function getParameters(): iterable {
		foreach ($this->node->params as $parameter) {
			yield new MethodParameter($parameter);
		}
	}
	
	public function getReturn(): string {
		if ($this->node->returnType instanceof NullableType || empty($this->node->returnType)) {
			return 'void';
		}
		return (string)$this->node->returnType;
	}
	
	public function isStatic(): bool {
		return $this->node->isStatic();
	}
}