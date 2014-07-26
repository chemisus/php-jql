<?php

namespace Jql;

use AbstractSoftValueTerm;
use Environment;

class JqlEntityOperation extends AbstractSoftValueTerm
{
    public function __construct()
    {
        parent::__construct('entity');
    }

    public function operate(Environment $env, $value)
    {
        $current = $env->current();

        if ($value === '*') {
            return $current;
        }

        return array($value => $current[$value]);
    }
}