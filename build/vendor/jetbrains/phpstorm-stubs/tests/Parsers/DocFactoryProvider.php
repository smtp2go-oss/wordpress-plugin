<?php

declare (strict_types=1);
namespace SMTP2GOWPPlugin\StubTests\Parsers;

use SMTP2GOWPPlugin\phpDocumentor\Reflection\DocBlockFactory;
use SMTP2GOWPPlugin\StubTests\Model\Tags\RemovedTag;
class DocFactoryProvider
{
    private static ?DocBlockFactory $docFactory = null;
    public static function getDocFactory() : DocBlockFactory
    {
        if (self::$docFactory === null) {
            self::$docFactory = DocBlockFactory::createInstance(['removed' => RemovedTag::class]);
        }
        return self::$docFactory;
    }
}
