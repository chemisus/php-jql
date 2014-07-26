<?php

namespace Sql;

use AbstractBinaryOperation;
use Environment;

class SqlAliasOperation extends AbstractBinaryOperation
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
        return "{$a} as \"{$b}\"";
    }
}