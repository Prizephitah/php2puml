<?php
declare(strict_types=1);

namespace Prizephitah\php2puml\Console;


use FilesystemIterator;
use PhpParser\ParserFactory;
use Prizephitah\php2puml\Generator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class GenerateFromDirectoryCommand extends Command {

	protected static $defaultName = 'php2uml:directory';

	protected function configure() {
		$this
			->setDescription('A whole directory')
			->setHelp('Reads all code in a directory and generates PlantUML describing it.')
			->addArgument('directory', InputArgument::REQUIRED, 'The path to the directory.')
			->addOption('output', 'o', InputOption::VALUE_REQUIRED, 'Where to put the result.', '-')
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		$generator = $this->startGenerator();

		$result = "@startuml\n";
		foreach ($this->fileGenerator($input) as $fileInfo) {
			if ($fileInfo->isReadable() && mb_strtolower($fileInfo->getExtension()) === 'php') {
				$fileContent = file_get_contents($fileInfo->getRealPath());
				$result .= $generator->fromString($fileContent, false);
			}
		}

		$result .= "\n@enduml";
		$this->output($input->getOption('output'), $output, $result);
		return Command::SUCCESS;
	}

	protected function startGenerator(): Generator {
		$parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
		$loader = new FilesystemLoader(__DIR__.'/../PlantUmlTemplates');
		$twig = new Environment($loader, ['strict_variables' => true]);

		return new Generator($parser, $twig);
	}

	/**
	 * @param InputInterface $input
	 * @return \Generator|SplFileInfo[]
	 */
	protected function fileGenerator(InputInterface $input): \Generator {
		$directory = new RecursiveDirectoryIterator($input->getArgument('directory'), FilesystemIterator::CURRENT_AS_FILEINFO);
		yield from new RecursiveIteratorIterator($directory);
	}

	protected function output($switch, OutputInterface $output, string $result) {
		if ($switch === '-') {
			$output->writeln($result);
		} else {
			file_put_contents($switch, $result);
		}
	}
}