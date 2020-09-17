#!/usr/bin/env php
<?php

use Prizephitah\php2puml\Console\GenerateFromDirectoryCommand;
use Symfony\Component\Console\Application;

require __DIR__.'/../vendor/autoload.php';

$app = new Application('Php2Uml', '0.1.0');
$command = new GenerateFromDirectoryCommand();
$app->add($command);
$app->setDefaultCommand($command->getName(), true);
$app->run();