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

    public function operate(Environment $env, $value)
    {
        $values = explode('.', $value);
        $value = '"' . implode('"."', $values) . '"';
        $value = str_replace('"*"', '*', $value);
        return $value;
    }
}