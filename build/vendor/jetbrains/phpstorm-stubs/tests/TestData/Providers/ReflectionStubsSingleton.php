<?php

declare (strict_types=1);
namespace SMTP2GOWPPlugin\StubTests\TestData\Providers;

use SMTP2GOWPPlugin\StubTests\Model\StubsContainer;
use SMTP2GOWPPlugin\StubTests\Parsers\PHPReflectionParser;
class ReflectionStubsSingleton
{
    private static ?StubsContainer $reflectionStubs = null;
    public static function getReflectionStubs() : StubsContainer
    {
        if (self::$reflectionStubs === null) {
            self::$reflectionStubs = PHPReflectionParser::getStubs();
        }
        return self::$reflectionStubs;
    }
}
