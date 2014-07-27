<?php

namespace Sql;

use AbstractBinaryOperation;
use Environment;

class SqlGreaterThanOperation extends AbstractBinaryOperation
{
    public function __construct()
    {
        parent::__construct('gt');
    }

    public function operate(Environment $env, $a, $b)
    {
        return "{$a}>{$b}";
    }
}