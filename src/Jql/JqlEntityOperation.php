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
            return array_reduce($current, 'array_merge', array());
        }

        $keys = explode('.', $term);

        if (count($keys) === 2) {
            return array($keys[1] => $current[$keys[0]][$keys[1]]);
            return array($keys[0] => array($keys[1] => $current[$keys[0]][$keys[1]]));
        }

        throw new \Exception('not yet implemented.');
    }
}