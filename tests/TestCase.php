<?php


namespace Prizephitah\php2puml\Test;


use PhpParser\ParserFactory;
use Prizephitah\php2puml\Generator\Generator;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class TestCase extends \PHPUnit\Framework\TestCase {
	
	protected Generator $generator;
	
	public function __construct(?string $name = null, array $data = [], $dataName = '') {
		parent::__construct($name, $data, $dataName);
		
		$parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
		$loader = new FilesystemLoader(__DIR__.'/../src/PlantUmlTemplates');
		$twig = new Environment($loader, ['strict_variables' => true]);
		
		$this->generator = new Generator($parser, $twig);
	}
	
	protected function assertEqualStrings(string $expected, $actual): void {
		$this->assertEquals(str_replace("\r\n", "\n", $expected), str_replace("\r\n", "\n", $actual));
	}
}