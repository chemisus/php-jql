<?php

namespace Sql;

use AbstractUnaryOperation;
use Environment;

class SqlFromOperation extends AbstractUnaryOperation
{
    public function __construct()
    {
        parent::__construct('from');
    }

    public function operate(Environment $env, $term)
    {
        return "from " . $term;
    }
}