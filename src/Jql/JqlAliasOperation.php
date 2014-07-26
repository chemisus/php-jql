<?php

namespace Jql;

use AbstractBinaryOperation;
use Environment;

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

    public function operate($a, $b)
    {
        return array($b => array_shift($a));
    }
}