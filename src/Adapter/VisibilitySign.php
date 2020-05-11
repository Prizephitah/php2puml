<?php
declare(strict_types=1);

namespace Prizephitah\php2puml\Adapter;


use PhpParser\Node\Stmt\ClassConst;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Property;

/**
 * @param ClassMethod|ClassConst|Property $node
 * @return string
 */
function visibilitySign($node): string {
	if ($node->isPrivate()) {
		return '-';
	}
	if ($node->isProtected()) {
		return '#';
	}
	return '+';
}