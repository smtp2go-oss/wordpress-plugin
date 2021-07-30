<?php

namespace SMTP2GOWPPlugin;

use SMTP2GOWPPlugin\JetBrains\PhpStorm\Pure;
/**
 * @since 8.0
 */
class ReflectionUnionType extends \ReflectionType
{
    /**
     * Get list of named types of union type
     *
     * @return ReflectionNamedType[]
     */
    #[Pure]
    public function getTypes()
    {
    }
}
/**
 * @since 8.0
 */
\class_alias('SMTP2GOWPPlugin\\ReflectionUnionType', 'ReflectionUnionType', \false);
