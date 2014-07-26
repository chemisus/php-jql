<?php

namespace Jql;

use AbstractTernaryOperation;
use Environment;
use AbstractBinaryOperation;

class JqlLeftJoinOperation extends AbstractBinaryOperation
{
    public function __construct()
    {
        parent::__construct('lj');
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

        if (!count($results)) {
            $results = array($env->current());
        }

        return $results;
    }

    public function operate($a, $b)
    {
        // TODO: Implement operate() method.
    }
}