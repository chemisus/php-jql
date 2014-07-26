<?php

namespace Jql;

use AbstractSoftValueTerm;
use Environment;

class JqlParameterOperation extends AbstractSoftValueTerm
{
    public function __construct()
    {
        parent::__construct('param');
    }

    public function operate(Environment $env, $term)
    {
        return $term;
    }
}