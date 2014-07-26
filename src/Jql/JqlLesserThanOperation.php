<?php

namespace Jql;

use AbstractBinaryOperation;

class JqlLesserThanOperation extends AbstractBinaryOperation
{
    public function __construct()
    {
        parent::__construct('lt');
    }

    public function operate($a, $b)
    {
        return $a < $b;
    }
}