<?php

namespace Sql;

use Environment;
use AbstractSoftValueTerm;

class SqlParameterOperation extends AbstractSoftValueTerm
{
    public function __construct()
    {
        parent::__construct('param');
    }

    public function operate(Environment $env, $value)
    {
        return ':' . $value;
    }
}