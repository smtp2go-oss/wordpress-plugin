<?php

declare (strict_types=1);
namespace SMTP2GOWPPlugin\StubTests\Parsers;

use SMTP2GOWPPlugin\PhpParser\Error;
use SMTP2GOWPPlugin\PhpParser\ErrorHandler;
class StubsParserErrorHandler implements ErrorHandler
{
    public function handleError(Error $error) : void
    {
        $error->setRawMessage($error->getRawMessage() . "\n" . $error->getFile());
    }
}
