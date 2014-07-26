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
            if (isset($current[$keys[0]])) {
                if (isset($current[$keys[0]][$keys[1]])) {
                    return array($keys[1] => $current[$keys[0]][$keys[1]]);
                }
            }

            return array($keys[1] => null);
        }

        if (count($keys) === 1) {
            $current = array_reduce($current, 'array_merge', array());
            if (isset($current[$keys[0]])) {
                return array($keys[0] => $current[$keys[0]]);
            }

            return array($keys[0] => null);
        }

        throw new \Exception('Invalid entity name.');
    }
}