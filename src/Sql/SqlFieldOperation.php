<?php

namespace Sql;

use AbstractSoftValueTerm;
use Environment;

class SqlFieldOperation extends AbstractSoftValueTerm
{
    public function __construct()
    {
        parent::__construct('field');
    }

    public function operate(Environment $env, $term)
    {
        $values = explode('.', $term);
        $term = '"' . implode('"."', $values) . '"';
        $term = str_replace('"*"', '*', $term);
        return $term;
    }
}