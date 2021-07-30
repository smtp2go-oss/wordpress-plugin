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
namespace SMTP2GOWPPlugin\Humbug\PhpScoper\PhpParser\NodeVisitor\UseStmt;

use SMTP2GOWPPlugin\Humbug\PhpScoper\PhpParser\NodeVisitor\NamespaceStmt\NamespaceStmtCollection;
use SMTP2GOWPPlugin\PhpParser\Node;
use SMTP2GOWPPlugin\PhpParser\Node\Stmt\Use_;
use SMTP2GOWPPlugin\PhpParser\NodeVisitorAbstract;
/**
 * Collects all the use statements. This allows us to resolve a class/constant/function call into a fully-qualified
 * call.
 *
 * @private
 */
final class UseStmtCollector extends NodeVisitorAbstract
{
    private $namespaceStatements;
    private $useStatements;
    public function __construct(NamespaceStmtCollection $namespaceStatements, UseStmtCollection $useStatements)
    {
        $this->namespaceStatements = $namespaceStatements;
        $this->useStatements = $useStatements;
    }
    /**
     * @inheritdoc
     */
    public function enterNode(Node $node) : Node
    {
        if ($node instanceof Use_) {
            $namespaceName = $this->namespaceStatements->getCurrentNamespaceName();
            $this->useStatements->add($namespaceName, $node);
        }
        return $node;
    }
}