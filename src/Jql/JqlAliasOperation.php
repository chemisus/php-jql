<?php

namespace Jql;

use Environment;
use AbstractBinaryOperation;

class JqlAliasOperation extends AbstractBinaryOperation
{
    public function __construct()
    {
        parent::__construct('alias');
    }

    public function runB(Environment $env, $term)
    {
        return $term;
    }

    public function verifyB(Environment $env, $term)
    {
        return true;
    }

    public function operate(Environment $env, $a, $b)
    {
        return array($b => array_shift($a));
    }
}