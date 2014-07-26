<?php

namespace Sql;

use AbstractSoftValueTerm;
use Environment;

class SqlParameterOperation extends AbstractSoftValueTerm
{
    public function __construct()
    {
        parent::__construct('param');
    }

    public function operate(Environment $env, $term)
    {
        $env->parameter($term);

        return '?';
    }
}