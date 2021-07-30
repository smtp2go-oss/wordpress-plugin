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
namespace SMTP2GOWPPlugin\Humbug\PhpScoper\PhpParser;

use SMTP2GOWPPlugin\Humbug\PhpScoper\PhpParser\NodeVisitor\NamespaceStmt\NamespaceStmtCollection;
use SMTP2GOWPPlugin\Humbug\PhpScoper\PhpParser\NodeVisitor\Resolver\FullyQualifiedNameResolver;
use SMTP2GOWPPlugin\Humbug\PhpScoper\PhpParser\NodeVisitor\UseStmt\UseStmtCollection;
use SMTP2GOWPPlugin\Humbug\PhpScoper\Reflector;
use SMTP2GOWPPlugin\Humbug\PhpScoper\Scoper\PhpScoper;
use SMTP2GOWPPlugin\Humbug\PhpScoper\Whitelist;
use SMTP2GOWPPlugin\PhpParser\NodeTraverserInterface;
/**
 * @private
 */
class TraverserFactory
{
    private $reflector;
    public function __construct(Reflector $reflector)
    {
        $this->reflector = $reflector;
    }
    public function create(PhpScoper $scoper, string $prefix, Whitelist $whitelist) : NodeTraverserInterface
    {
        $traverser = new NodeTraverser();
        $namespaceStatements = new NamespaceStmtCollection();
        $useStatements = new UseStmtCollection();
        $nameResolver = new FullyQualifiedNameResolver($namespaceStatements, $useStatements);
        $traverser->addVisitor(new NodeVisitor\ParentNodeAppender());
        $traverser->addVisitor(new NodeVisitor\NamespaceStmt\NamespaceStmtPrefixer($prefix, $whitelist, $namespaceStatements));
        $traverser->addVisitor(new NodeVisitor\UseStmt\UseStmtCollector($namespaceStatements, $useStatements));
        $traverser->addVisitor(new NodeVisitor\UseStmt\UseStmtPrefixer($prefix, $whitelist, $this->reflector));
        $traverser->addVisitor(new NodeVisitor\NamespaceStmt\FunctionIdentifierRecorder($prefix, $nameResolver, $whitelist, $this->reflector));
        $traverser->addVisitor(new NodeVisitor\ClassIdentifierRecorder($prefix, $nameResolver, $whitelist));
        $traverser->addVisitor(new NodeVisitor\NameStmtPrefixer($prefix, $whitelist, $namespaceStatements, $useStatements, $nameResolver, $this->reflector));
        $traverser->addVisitor(new NodeVisitor\StringScalarPrefixer($prefix, $whitelist, $this->reflector));
        $traverser->addVisitor(new NodeVisitor\NewdocPrefixer($scoper, $prefix, $whitelist));
        $traverser->addVisitor(new NodeVisitor\EvalPrefixer($scoper, $prefix, $whitelist));
        $traverser->addVisitor(new NodeVisitor\ClassAliasStmtAppender($prefix, $whitelist, $nameResolver));
        $traverser->addVisitor(new NodeVisitor\ConstStmtReplacer($whitelist, $nameResolver));
        return $traverser;
    }
}
