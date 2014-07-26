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

        if (count($keys) === 1) {
            $current = array_reduce($current, 'array_merge', array());

            return $current[$keys[0]];
        }

        throw new \Exception('Invalid field name.');
    }
}