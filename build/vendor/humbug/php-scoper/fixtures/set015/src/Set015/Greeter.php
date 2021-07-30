<?php

declare (strict_types=1);
namespace SMTP2GOWPPlugin\Set015;

use SMTP2GOWPPlugin\Pimple\Container;
class Greeter
{
    public function greet(Container $c) : string
    {
        return $c['hello'];
    }
}
