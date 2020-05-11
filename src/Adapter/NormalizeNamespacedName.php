<?php
declare(strict_types=1);

namespace Prizephitah\php2puml\Adapter;


/**
 * Exchanges the namespace separator from the PHP-specific backslash to the PlantUML-default period.
 * @param string $name
 * @return string
 */
function normalizeNamespacedName(string $name): string {
	return strtr($name, '\\', '.');
}