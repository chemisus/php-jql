<?php

namespace Sql;

use AbstractUnaryOperation;

class SqlFromOperation extends AbstractUnaryOperation
{
    public function __construct()
    {
        parent::__construct('from');
    }

    public function operate($term)
    {
        return "from " . $term;
    }
}