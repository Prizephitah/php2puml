<?php


namespace Prizephitah\php2puml;


use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\NameResolver;
use PhpParser\Parser;

class Generator {
	
	/** @var Parser */
	protected $parser;
	
	public function __construct(Parser $parser) {
		$this->parser = $parser;
	}
	
	public function fromString(string $code): string {
		$nodes = $this->parser->parse($code);
		$nameResolver = new NameResolver();
		$nodeTraverser = new NodeTraverser();
		$nodeTraverser->addVisitor($nameResolver);
		$nodes = $nodeTraverser->traverse($nodes);
		
		$output = "@startuml\r\n";
		foreach ($this->filterClasses($nodes) as $classLike) {
			$output .= 'class '.strtr($classLike->namespacedName, '\\', '.')." {\r\n";
			foreach ($classLike->getMethods() as $method) {
				$output .= '	'.$method->name."()\r\n";
			}
			$output .= "}\r\n";
		}
		$output .= '@enduml';
		return $output;
	}
	
	/**
	 * @param array $nodes
	 * @return ClassLike[]|\Generator
	 */
	protected function filterClasses(array $nodes): iterable {
		foreach ($nodes as $node) {
			if ($node instanceof Namespace_) {
				yield from $this->filterClasses($node->stmts);
			}
			if ($node instanceof ClassLike) {
				yield $node;
			}
		}
	}
}