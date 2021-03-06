<?php

namespace Jql;

use AbstractBinaryOperation;
use Environment;

class JqlRightJoinOperation extends AbstractBinaryOperation
{
    public function __construct()
    {
        parent::__construct('rj');
    }

    public function run(Environment $env, $term)
    {
        $results = array();

        foreach($this->runA($env, $env->get($term, 'a')) as $table=>$rows) {
            foreach($rows as $row) {
                $current = array_merge($env->current(), array($table => $row));

                $env->push($current);

                if ($this->runB($env, $env->get($term, 'b'))) {
                    $results[] = $current;
                }

                $env->pop();
            }
        }

        return $results;
    }

    public function operate(Environment $env, $a, $b)
    {
        // TODO: Implement operate() method.
    }
}