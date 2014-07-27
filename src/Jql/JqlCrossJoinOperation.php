<?php

namespace Jql;

use AbstractSoftValueTerm;
use Environment;

class JqlCrossJoinOperation extends AbstractSoftValueTerm
{
    public function __construct()
    {
        parent::__construct('cj');
    }

    public function run(Environment $env, $term)
    {
        $results = array();

        foreach ($this->runA($env, $env->get($term, 'a')) as $table => $rows) {
            foreach ($rows as $row) {

                $current = array_merge($env->current(), array($table => $row));
                $env->push($current);
                $results[] = $current;
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