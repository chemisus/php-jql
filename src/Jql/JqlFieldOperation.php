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

        $keys = explode('.', $term);

        if (count($keys) === 2) {
            return $current[$keys[0]][$keys[1]];
        }

        throw new \Exception('not yet implemented.');
    }
}