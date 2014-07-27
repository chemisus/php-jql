<?php

namespace Sql;

use AbstractUnaryOperation;
use Environment;

class SqlNotOperation extends AbstractUnaryOperation
{
    public function __construct()
    {
        parent::__construct('not');
    }

    public function operate(Environment $env, $term)
    {
        return "not " . $term;
    }
}