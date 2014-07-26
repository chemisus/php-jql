<?php

namespace Sql;

use AbstractBinaryOperation;

class SqlGreaterThanOperation extends AbstractBinaryOperation
{
    public function __construct()
    {
        parent::__construct('gt');
    }

    public function operate($a, $b)
    {
        return "{$a}>{$b}";
    }
}