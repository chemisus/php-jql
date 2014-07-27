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

    public function operate(Environment $env, $v)
    {
        $results = array();

        foreach ($env->run($v) as $table => $rows) {
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
}