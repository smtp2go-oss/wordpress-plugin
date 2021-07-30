<?php

declare (strict_types=1);
namespace SMTP2GOWPPlugin;

function foo() : bool
{
    return \true;
}
if (!\function_exists('SMTP2GOWPPlugin\\bar')) {
    function bar() : bool
    {
        return \true;
    }
}
if (\function_exists('SMTP2GOWPPlugin\\baz')) {
    baz();
}
