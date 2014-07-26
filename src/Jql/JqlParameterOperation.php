<?php

namespace Jql;

use Environment;
use AbstractSoftValueTerm;

class JqlParameterOperation extends AbstractSoftValueTerm
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