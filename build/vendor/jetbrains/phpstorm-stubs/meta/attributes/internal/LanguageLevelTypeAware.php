<?php

namespace SMTP2GOWPPlugin\JetBrains\PhpStorm\Internal;

use Attribute;
use SMTP2GOWPPlugin\JetBrains\PhpStorm\Deprecated;
use SMTP2GOWPPlugin\JetBrains\PhpStorm\ExpectedValues;
/**
 * For PhpStorm internal use only
 * @since 8.0
 * @internal
 */
#[Attribute(Attribute::TARGET_FUNCTION | Attribute::TARGET_PARAMETER)]
class LanguageLevelTypeAware
{
    public function __construct(array $languageLevelTypeMap, string $default)
    {
    }
}
