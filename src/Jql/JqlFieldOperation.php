<?php

namespace Jql;

use AbstractSoftValueTerm;
use Environment;

class JqlFieldOperation extends AbstractSoftValueTerm
{
    public function __construct()
    {
        parent::__construct('field');
    }

    public function operate(Environment $env, $term)
    {
        $current = $env->current();

        return $current[$term];
    }
}