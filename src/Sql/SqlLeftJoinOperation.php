<?php

namespace Sql;

use AbstractBinaryOperation;
use Environment;

class SqlLeftJoinOperation extends AbstractBinaryOperation
{
    public function __construct()
    {
        parent::__construct('lj');
    }

    public function operate(Environment $env, $a, $b)
    {
        return "left join {$a} on {$b}";
    }
}