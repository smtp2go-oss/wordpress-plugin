<?php

declare (strict_types=1);
/*
 * This file is part of the humbug/php-scoper package.
 *
 * Copyright (c) 2017 Théo FIDRY <theo.fidry@gmail.com>,
 *                    Pádraic Brady <padraic.brady@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SMTP2GOWPPlugin\Humbug\PhpScoper;

use SMTP2GOWPPlugin\JetBrains\PHPStormStub\PhpStormStubsMap;
use function array_fill_keys;
use function array_keys;
use function array_merge;
use function strtolower;
/**
 * @private
 */
final class Reflector
{
    private const MISSING_CLASSES = [
        // https://github.com/JetBrains/phpstorm-stubs/pull/594
        'SMTP2GOWPPlugin\\parallel\\Channel',
        'SMTP2GOWPPlugin\\parallel\\Channel\\Error',
        'SMTP2GOWPPlugin\\parallel\\Channel\\Error\\Closed',
        'SMTP2GOWPPlugin\\parallel\\Channel\\Error\\Existence',
        'SMTP2GOWPPlugin\\parallel\\Channel\\Error\\IllegalValue',
        'SMTP2GOWPPlugin\\parallel\\Error',
        'SMTP2GOWPPlugin\\parallel\\Events',
        'SMTP2GOWPPlugin\\parallel\\Events\\Error',
        'SMTP2GOWPPlugin\\parallel\\Events\\Error\\Existence',
        'SMTP2GOWPPlugin\\parallel\\Events\\Error\\Timeout',
        'SMTP2GOWPPlugin\\parallel\\Events\\Event',
        'SMTP2GOWPPlugin\\parallel\\Events\\Event\\Type',
        'SMTP2GOWPPlugin\\parallel\\Events\\Input',
        'SMTP2GOWPPlugin\\parallel\\Events\\Input\\Error',
        'SMTP2GOWPPlugin\\parallel\\Events\\Input\\Error\\Existence',
        'SMTP2GOWPPlugin\\parallel\\Events\\Input\\Error\\IllegalValue',
        'SMTP2GOWPPlugin\\parallel\\Future',
        'SMTP2GOWPPlugin\\parallel\\Future\\Error',
        'SMTP2GOWPPlugin\\parallel\\Future\\Error\\Cancelled',
        'SMTP2GOWPPlugin\\parallel\\Future\\Error\\Foreign',
        'SMTP2GOWPPlugin\\parallel\\Future\\Error\\Killed',
        'SMTP2GOWPPlugin\\parallel\\Runtime',
        'SMTP2GOWPPlugin\\parallel\\Runtime\\Bootstrap',
        'SMTP2GOWPPlugin\\parallel\\Runtime\\Error',
        'SMTP2GOWPPlugin\\parallel\\Runtime\\Error\\Bootstrap',
        'SMTP2GOWPPlugin\\parallel\\Runtime\\Error\\Closed',
        'SMTP2GOWPPlugin\\parallel\\Runtime\\Error\\IllegalFunction',
        'SMTP2GOWPPlugin\\parallel\\Runtime\\Error\\IllegalInstruction',
        'SMTP2GOWPPlugin\\parallel\\Runtime\\Error\\IllegalParameter',
        'SMTP2GOWPPlugin\\parallel\\Runtime\\Error\\IllegalReturn',
    ];
    private const MISSING_FUNCTIONS = [];
    private const MISSING_CONSTANTS = [
        'STDIN',
        'STDOUT',
        'STDERR',
        // Added in PHP 7.4
        'T_BAD_CHARACTER',
        'T_FN',
        'T_COALESCE_EQUAL',
        // Added in PHP 8.0
        'T_NAME_QUALIFIED',
        'T_NAME_FULLY_QUALIFIED',
        'T_NAME_RELATIVE',
        'T_MATCH',
        'T_NULLSAFE_OBJECT_OPERATOR',
        'T_ATTRIBUTE',
    ];
    private static $CLASSES;
    private static $FUNCTIONS;
    private static $CONSTANTS;
    /**
     * @param array<string,string>|null $symbols
     * @param array<string,string>      $source
     * @param string[]                  $missingSymbols
     */
    private static function initSymbolList(?array &$symbols, array $source, array $missingSymbols) : void
    {
        if (null !== $symbols) {
            return;
        }
        $symbols = array_fill_keys(array_merge(array_keys($source), $missingSymbols), \true);
    }
    public function __construct()
    {
        self::initSymbolList(self::$CLASSES, PhpStormStubsMap::CLASSES, self::MISSING_CLASSES);
        self::initSymbolList(self::$FUNCTIONS, PhpStormStubsMap::FUNCTIONS, self::MISSING_FUNCTIONS);
        self::initSymbolList(self::$CONSTANTS, PhpStormStubsMap::CONSTANTS, self::MISSING_CONSTANTS);
    }
    public function isClassInternal(string $name) : bool
    {
        return isset(self::$CLASSES[$name]);
    }
    public function isFunctionInternal(string $name) : bool
    {
        return isset(self::$FUNCTIONS[strtolower($name)]);
    }
    public function isConstantInternal(string $name) : bool
    {
        return isset(self::$CONSTANTS[$name]);
    }
}
