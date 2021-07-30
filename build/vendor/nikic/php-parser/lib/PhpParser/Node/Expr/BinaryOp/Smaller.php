<?php

declare (strict_types=1);
namespace SMTP2GOWPPlugin\PhpParser\Node\Expr\BinaryOp;

use SMTP2GOWPPlugin\PhpParser\Node\Expr\BinaryOp;
class Smaller extends BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '<';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_Smaller';
    }
}
