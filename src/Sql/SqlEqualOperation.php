<?php

namespace Sql;

use AbstractBinaryOperation;
use Environment;

class SqlEqualOperation extends AbstractBinaryOperation
{
    public function __construct()
    {
        parent::__construct('equal');
    }

    public function operate(Environment $env, $a, $b)
    {
        return "{$a}={$b}";
    }
}