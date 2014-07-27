<?php

namespace Sql;

use AbstractSoftValueTerm;
use Environment;

class SqlCrossJoinOperation extends AbstractSoftValueTerm
{
    public function __construct()
    {
        parent::__construct('lj');
    }

    public function operate(Environment $env, $a)
    {
        return "cross join {$a}";
    }
}