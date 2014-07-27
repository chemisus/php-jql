<?php

namespace Sql;

use AbstractSoftValueTerm;
use Environment;

class SqlCrossJoinOperation extends AbstractSoftValueTerm
{
    public function __construct()
    {
        parent::__construct('cj');
    }

    public function operate(Environment $env, $v)
    {
        return "cross join " . $env->run($v);
    }
}