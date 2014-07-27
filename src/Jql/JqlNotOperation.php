<?php

namespace Jql;

use AbstractUnaryOperation;
use Environment;

class JqlNotOperation extends AbstractUnaryOperation
{
    public function __construct()
    {
        parent::__construct('not');
    }

    public function operate(Environment $env, $term)
    {
        return !$term;
    }
}