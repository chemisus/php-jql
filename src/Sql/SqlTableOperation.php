<?php

namespace Sql;

use AbstractSoftValueTerm;
use Environment;

class SqlTableOperation extends AbstractSoftValueTerm
{
    public function __construct()
    {
        parent::__construct('table');
    }

    public function operate(Environment $env, $term)
    {
        return '"' . $term . '"';
    }
}