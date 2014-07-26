<?php

namespace Sql;

use AbstractBinaryOperation;

class SqlEqualOperation extends AbstractBinaryOperation
{
    public function __construct()
    {
        parent::__construct('equal');
    }

    public function operate($a, $b)
    {
        return "{$a}={$b}";
    }
}