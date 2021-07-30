<?php

declare (strict_types=1);
namespace SMTP2GOWPPlugin\PhpParser\Node\Stmt;

use SMTP2GOWPPlugin\PhpParser\Node;
/** Nop/empty statement (;). */
class Nop extends Node\Stmt
{
    public function getSubNodeNames() : array
    {
        return [];
    }
    public function getType() : string
    {
        return 'Stmt_Nop';
    }
}
