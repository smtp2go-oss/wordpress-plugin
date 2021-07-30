<?php

declare (strict_types=1);
namespace SMTP2GOWPPlugin\PhpParser\ErrorHandler;

use SMTP2GOWPPlugin\PhpParser\Error;
use SMTP2GOWPPlugin\PhpParser\ErrorHandler;
/**
 * Error handler that handles all errors by throwing them.
 *
 * This is the default strategy used by all components.
 */
class Throwing implements ErrorHandler
{
    public function handleError(Error $error)
    {
        throw $error;
    }
}
