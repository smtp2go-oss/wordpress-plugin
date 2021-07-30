<?php

declare (strict_types=1);
namespace SMTP2GOWPPlugin\PhpParser\Node\Expr\BinaryOp;

use SMTP2GOWPPlugin\PhpParser\Node\Expr\BinaryOp;
class LogicalXor extends BinaryOp
{
    public function getOperatorSigil() : string
    {
        return 'xor';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_LogicalXor';
    }
}
