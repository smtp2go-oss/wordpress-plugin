<?php

declare (strict_types=1);
namespace SMTP2GOWPPlugin\StubTests\Parsers\Visitors;

use SMTP2GOWPPlugin\StubTests\Model\StubsContainer;
class CoreStubASTVisitor extends ASTVisitor
{
    public function __construct(StubsContainer $stubs)
    {
        parent::__construct($stubs);
        $this->isStubCore = \true;
    }
}
