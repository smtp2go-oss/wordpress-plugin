<?php

declare (strict_types=1);
namespace SMTP2GOWPPlugin\StubTests\TestData\Providers;

use SMTP2GOWPPlugin\StubTests\Model\StubsContainer;
use SMTP2GOWPPlugin\StubTests\Parsers\StubParser;
class PhpStormStubsSingleton
{
    private static ?StubsContainer $phpstormStubs = null;
    public static function getPhpStormStubs() : StubsContainer
    {
        if (self::$phpstormStubs === null) {
            self::$phpstormStubs = StubParser::getPhpStormStubs();
        }
        return self::$phpstormStubs;
    }
}
