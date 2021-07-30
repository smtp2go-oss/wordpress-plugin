<?php

declare (strict_types=1);
namespace SMTP2GOWPPlugin;

require_once __DIR__ . '/../vendor/autoload.php';
use SMTP2GOWPPlugin\Assert\Assertion;
use SMTP2GOWPPlugin\Set005\Greeter;
Assertion::true(\true);
echo (new Greeter())->greet() . \PHP_EOL;
