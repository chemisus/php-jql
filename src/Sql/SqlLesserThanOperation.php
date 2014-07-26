<?php

namespace Sql;

use AbstractBinaryOperation;

class SqlLesserThanOperation extends AbstractBinaryOperation
{
    public function __construct()
    {
        parent::__construct('lt');
    }

    public function operate($a, $b)
    {
        return "{$a}<{$b}";
    }
}