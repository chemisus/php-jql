<?php

namespace Sql;

use AbstractBinaryOperation;
use Environment;

class SqlSubqueryOperation extends AbstractBinaryOperation
{
    public function __construct()
    {
        parent::__construct('sq');
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
        return "({$a}) as \"{$b}\"";
    }
}