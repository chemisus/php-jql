<?php

namespace Sql;

use AbstractBinaryOperation;
use Environment;

class SqlRightJoinOperation extends AbstractBinaryOperation
{
    public function __construct()
    {
        parent::__construct('rj');
    }

    public function operate(Environment $env, $a, $b)
    {
        return "right join {$a} on {$b}";
    }
}