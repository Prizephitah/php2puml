<?php
declare(strict_types=1);

namespace Prizephitah\php2puml\Generator;


use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\NameResolver;
use PhpParser\Parser;
use Prizephitah\php2puml\Adapter;
use Prizephitah\php2puml\Generator\GeneratorOptions;
use Twig\Environment;
use Twig\Extension\CoreExtension;
use Twig\Extension\EscaperExtension;
use Twig\Extension\ExtensionInterface;

class Generator {
	
	protected Parser $parser;
	protected Environment $twig;
	
	public function __construct(Parser $parser, Environment $twig) {
		$this->parser = $parser;
		$this->twig = $twig;
		
		// Disable escaping
		/** @var EscaperExtension $escapeExtension */
		$escapeExtension = $this->twig->getExtension(EscaperExtension::class);
		$escapeExtension->setDefaultStrategy(false);
	}
	
	public function fromString(string $code, ?GeneratorOptions $options = null): string {
		if ($options === null) {
			$options = new GeneratorOptions();
		}
		$nodes = $this->parser->parse($code);
		$nameResolver = new NameResolver();
		$nodeTraverser = new NodeTraverser();
		$nodeTraverser->addVisitor($nameResolver);
		$nodes = $nodeTraverser->traverse($nodes);
		
		$template = $this->twig->load('PlantUml.twig');
		return $this->removeEmptyLines($template->render([
			'classLikes' => $this->filterClasses($nodes, $options),
			'enclose' => $options->enclose
		]));
	}
	
	/**
	 * @param array $nodes
	 * @return Adapter\ClassLike[]|\Generator
	 */
	protected function filterClasses(array $nodes, GeneratorOptions $options, Namespace_ $namespace = null): iterable {
		foreach ($nodes as $node) {
			if ($node instanceof Namespace_) {
				if ($node->name === null || !self::isAllowedNamespace($node->name->parts, $options)) {
					continue;
				}
				yield from $this->filterClasses($node->stmts, $options, $node);
			}
			if ($options->includeGlobalNamespace === false && $namespace === null) {
				continue;
			}
			if ($node instanceof ClassLike) {
				yield new Adapter\ClassLike($node, $options);
			}
		}
	}
	
	protected function removeEmptyLines(string $input): string {
		return preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $input);
	}

	/**
	 * @param string[] $namespace
	 * @param GeneratorOptions $options
	 * @return bool
	 */
	public static function isAllowedNamespace(array $namespace, GeneratorOptions $options): bool {
		// If no filter, always allow
		if (empty($options->namespaceFilter)) {
			return true;
		}
		$allowed = preg_split('/[\\\]/', $options->namespaceFilter);
		$i = 0;
		foreach ($namespace as $candidateNamespacePart) {
			if (!isset($allowed[$i])) {
				return true;
			}
			if (mb_strtolower($candidateNamespacePart) !== mb_strtolower($allowed[$i])) {
				return false;
			}
			$i++;
		}
		return true;
	}
}