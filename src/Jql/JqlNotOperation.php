<?php

namespace Jql;

use AbstractUnaryOperation;

class JqlNotOperation extends AbstractUnaryOperation
{
    public function __construct()
    {
        parent::__construct('not');
    }

    public function operate($value)
    {
        return !$value;
    }
}