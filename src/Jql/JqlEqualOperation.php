<?php

namespace Jql;

use AbstractBinaryOperation;

class JqlEqualOperation extends AbstractBinaryOperation
{
    public function __construct()
    {
        parent::__construct('equal');
    }

    public function operate($a, $b)
    {
        return $a === $b;
    }
}