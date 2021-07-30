<?php

declare (strict_types=1);
namespace SMTP2GOWPPlugin\StubTests\Model;

use Exception;
use SMTP2GOWPPlugin\JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;
use SMTP2GOWPPlugin\PhpParser\Node;
use SMTP2GOWPPlugin\PhpParser\Node\Expr\Array_;
use SMTP2GOWPPlugin\PhpParser\Node\Identifier;
use SMTP2GOWPPlugin\PhpParser\Node\Name;
use SMTP2GOWPPlugin\PhpParser\Node\NullableType;
use SMTP2GOWPPlugin\PhpParser\Node\Scalar\String_;
use SMTP2GOWPPlugin\PhpParser\Node\UnionType;
use ReflectionNamedType;
use ReflectionType;
use ReflectionUnionType;
use Reflector;
use stdClass;
abstract class BasePHPElement
{
    public ?string $name = null;
    public bool $stubBelongsToCore = \false;
    public ?Exception $parseError = null;
    public array $mutedProblems = [];
    public abstract function readObjectFromReflection(Reflector $reflectionObject) : static;
    public abstract function readObjectFromStubNode(Node $node) : static;
    public abstract function readMutedProblems(stdClass|array $jsonData) : void;
    protected function getFQN(Node $node) : string
    {
        $fqn = '';
        if ($node->namespacedName === null) {
            $fqn = $node->name->parts[0];
        } else {
            /**@var string $part */
            foreach ($node->namespacedName->parts as $part) {
                $fqn .= "{$part}\\";
            }
        }
        return \rtrim($fqn, "\\");
    }
    protected static function convertReflectionTypeToString(?ReflectionType $type) : string
    {
        if ($type instanceof ReflectionNamedType) {
            return (string) $type;
        }
        if ($type instanceof ReflectionUnionType) {
            $reflectionType = '';
            foreach ($type->getTypes() as $type) {
                $reflectionType .= (string) $type . '|';
            }
            return \substr($reflectionType, 0, -1);
        }
        return '';
    }
    protected static function convertParsedTypeToString(Name|Identifier|NullableType|string|UnionType|null $type) : string
    {
        if ($type !== null) {
            if ($type instanceof UnionType) {
                $unionType = '';
                foreach ($type->types as $type) {
                    $unionType .= self::getTypeNameFromNode($type) . '|';
                }
                return \substr($unionType, 0, -1);
            } else {
                return self::getTypeNameFromNode($type);
            }
        }
        return '';
    }
    protected static function getTypeNameFromNode(Name|Identifier|NullableType|string $type) : string
    {
        $nullable = \false;
        if ($type instanceof NullableType) {
            $type = $type->type;
            $nullable = \true;
        }
        if (empty($type->name)) {
            if (!empty($type->parts)) {
                return $nullable ? '?' . $type->parts[0] : $type->parts[0];
            }
        } else {
            return $nullable ? '?' . $type->name : $type->name;
        }
    }
    protected static function findTypeFromAttribute(array $attrGroups) : ?string
    {
        foreach ($attrGroups as $attrGroup) {
            foreach ($attrGroup->attrs as $attr) {
                if ($attr->name->toString() === LanguageLevelTypeAware::class) {
                    $arg = $attr->args[0]->value;
                    if ($arg instanceof Array_) {
                        $value = $arg->items[0]->value;
                        if ($value instanceof String_) {
                            return $value->value;
                        }
                    }
                }
            }
        }
        return null;
    }
    public function hasMutedProblem(int $stubProblemType) : bool
    {
        return \in_array($stubProblemType, $this->mutedProblems, \true);
    }
}