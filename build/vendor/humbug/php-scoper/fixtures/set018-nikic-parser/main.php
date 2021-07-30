<?php

declare (strict_types=1);
namespace SMTP2GOWPPlugin;

use SMTP2GOWPPlugin\PhpParser\NodeDumper;
use SMTP2GOWPPlugin\PhpParser\ParserFactory;
require_once __DIR__ . '/vendor/autoload.php';
$code = <<<'CODE'
<?php

namespace SMTP2GOWPPlugin;

function test($foo)
{
    \var_dump($foo);
}
CODE;
$parser = (new ParserFactory())->create(ParserFactory::PREFER_PHP7);
$ast = $parser->parse($code);
$dumper = new NodeDumper();
echo $dumper->dump($ast) . "\n";
