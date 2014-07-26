<?php

namespace Sql;

use AbstractBinaryOperation;

class SqlRightJoinOperation extends AbstractBinaryOperation
{
    public function __construct()
    {
        parent::__construct('rj');
    }

    public function operate($a, $b)
    {
        return " right join {$a} on {$b}";
    }
}