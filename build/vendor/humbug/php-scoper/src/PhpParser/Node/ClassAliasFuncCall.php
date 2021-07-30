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
namespace SMTP2GOWPPlugin\Humbug\PhpScoper\PhpParser\Node;

use SMTP2GOWPPlugin\PhpParser\Node\Arg;
use SMTP2GOWPPlugin\PhpParser\Node\Expr\ConstFetch;
use SMTP2GOWPPlugin\PhpParser\Node\Expr\FuncCall;
use SMTP2GOWPPlugin\PhpParser\Node\Name\FullyQualified;
use SMTP2GOWPPlugin\PhpParser\Node\Scalar\String_;
final class ClassAliasFuncCall extends FuncCall
{
    /**
     * @inheritdoc
     */
    public function __construct(FullyQualified $prefixedName, FullyQualified $originalName, array $attributes = [])
    {
        parent::__construct(new FullyQualified('class_alias'), [new Arg(new String_((string) $prefixedName)), new Arg(new String_((string) $originalName)), new Arg(new ConstFetch(new FullyQualified('false')))], $attributes);
    }
}
