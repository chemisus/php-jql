<?php

namespace Sql;

use AbstractSoftValueTerm;
use Environment;

class SqlEntityOperation extends AbstractSoftValueTerm
{
    public function __construct()
    {
        parent::__construct('entity');
    }

    public function operate(Environment $env, $term)
    {
        $values = explode('.', $term);
        $term = '"' . implode('"."', $values) . '"';
        $term = str_replace('"*"', '*', $term);
        return $term;
    }
}