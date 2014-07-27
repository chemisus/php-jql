<?php

namespace Jql;

use AbstractBinaryOperation;
use Environment;

class JqlEqualOperation extends AbstractBinaryOperation
{
    public function __construct()
    {
        parent::__construct('equal');
    }

    public function operate(Environment $env, $a, $b)
    {
        return $a === $b;
    }
}