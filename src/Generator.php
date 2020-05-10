<?php


namespace Prizephitah\php2puml;


use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\NameResolver;
use PhpParser\Parser;
use Twig\Environment;

class Generator {
	
	protected Parser $parser;
	protected Environment $twig;
	
	public function __construct(Parser $parser, Environment $twig) {
		$this->parser = $parser;
		$this->twig = $twig;
	}
	
	public function fromString(string $code): string {
		$nodes = $this->parser->parse($code);
		$nameResolver = new NameResolver();
		$nodeTraverser = new NodeTraverser();
		$nodeTraverser->addVisitor($nameResolver);
		$nodes = $nodeTraverser->traverse($nodes);
		
		$template = $this->twig->load('PlantUml.twig');
		return $template->render([
			'classLikes' => $this->filterClasses($nodes)
		]);
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