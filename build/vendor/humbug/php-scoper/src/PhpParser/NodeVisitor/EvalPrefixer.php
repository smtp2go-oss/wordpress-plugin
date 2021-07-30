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
namespace SMTP2GOWPPlugin\Humbug\PhpScoper\PhpParser\NodeVisitor;

use SMTP2GOWPPlugin\Humbug\PhpScoper\PhpParser\StringScoperPrefixer;
use SMTP2GOWPPlugin\PhpParser\Node;
use SMTP2GOWPPlugin\PhpParser\Node\Expr\Eval_;
use SMTP2GOWPPlugin\PhpParser\Node\Scalar\String_;
use SMTP2GOWPPlugin\PhpParser\NodeVisitorAbstract;
final class EvalPrefixer extends NodeVisitorAbstract
{
    use StringScoperPrefixer;
    /**
     * @inheritdoc
     */
    public function enterNode(Node $node) : Node
    {
        if ($node instanceof String_ && ParentNodeAppender::findParent($node) instanceof Eval_) {
            $this->scopeStringValue($node);
        }
        return $node;
    }
}
