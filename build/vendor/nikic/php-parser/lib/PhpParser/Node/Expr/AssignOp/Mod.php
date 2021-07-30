<?php

declare (strict_types=1);
namespace SMTP2GOWPPlugin\PhpParser\Node\Expr\AssignOp;

use SMTP2GOWPPlugin\PhpParser\Node\Expr\AssignOp;
class Mod extends AssignOp
{
    public function getType() : string
    {
        return 'Expr_AssignOp_Mod';
    }
}
