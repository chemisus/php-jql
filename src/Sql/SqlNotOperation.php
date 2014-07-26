<?php

namespace Sql;

use AbstractUnaryOperation;

class SqlNotOperation extends AbstractUnaryOperation
{
    public function __construct()
    {
        parent::__construct('not');
    }

    public function operate($term)
    {
        return "not " . $term;
    }
}