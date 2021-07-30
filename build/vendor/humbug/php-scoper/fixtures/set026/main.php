<?php

declare (strict_types=1);
namespace SMTP2GOWPPlugin;

use SMTP2GOWPPlugin\Acme\Foo as FooClass;
use const SMTP2GOWPPlugin\Acme\FOO as FOO_CONST;
use function SMTP2GOWPPlugin\Acme\foo as foo_func;
if (\file_exists($autoload = __DIR__ . '/vendor/scoper-autoload.php')) {
    require_once $autoload;
} else {
    require_once __DIR__ . '/vendor/autoload.php';
}
(new FooClass())();
foo_func();
echo FOO_CONST . \PHP_EOL;
