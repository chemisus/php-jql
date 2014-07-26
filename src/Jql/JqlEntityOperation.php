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

    public function operate(Environment $env, $term)
    {
        $current = $env->current();

        if ($term === '*') {
            return $current;
        }

        return array($term => $current[$term]);
    }
}