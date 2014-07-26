<?php

namespace Jql;

use AbstractBinaryOperation;

class JqlGreaterThanOperation extends AbstractBinaryOperation
{
    public function __construct()
    {
        parent::__construct('gt');
    }

    public function operate($a, $b)
    {
        return $a > $b;
    }
}