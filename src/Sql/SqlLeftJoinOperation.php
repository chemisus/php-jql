<?php

namespace Sql;

use AbstractBinaryOperation;

class SqlLeftJoinOperation extends AbstractBinaryOperation
{
    public function __construct()
    {
        parent::__construct('lj');
    }

    public function operate($a, $b)
    {
        return " left join {$a} on {$b}";
    }
}