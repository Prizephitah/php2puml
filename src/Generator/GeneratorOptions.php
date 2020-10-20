<?php
declare(strict_types=1);

namespace Prizephitah\php2puml\Generator;


class GeneratorOptions {

	public bool $enclose = true;

	public ?string $namespaceFilter = null;

	public bool $includeGlobalNamespace = true;
}