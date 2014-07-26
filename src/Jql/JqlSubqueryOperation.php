<?php

namespace Jql;

use AbstractBinaryOperation;
use Environment;

class JqlSubqueryOperation extends AbstractBinaryOperation
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
        return array($b => $a);
    }
}