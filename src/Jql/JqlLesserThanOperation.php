<?php

namespace Jql;

use AbstractBinaryOperation;
use Environment;

class JqlLesserThanOperation extends AbstractBinaryOperation
{
    public function __construct()
    {
        parent::__construct('lt');
    }

    public function operate(Environment $env, $a, $b)
    {
        return $a < $b;
    }
}