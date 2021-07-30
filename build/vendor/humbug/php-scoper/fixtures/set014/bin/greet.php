<?php

declare (strict_types=1);
namespace SMTP2GOWPPlugin;

require_once __DIR__ . '/../vendor/autoload.php';
use SMTP2GOWPPlugin\Set014\Greeter;
echo (new Greeter())->greet() . \PHP_EOL;
