<?php

namespace Sql;

use Environment;
use stdClass;
use AbstractListOperation;

class SqlAndOperation extends AbstractListOperation
{
    public function __construct()
    {
        parent::__construct('and');
    }

    /**
     * @param Environment $env
     * @param stdClass $value
     * @return mixed
     */
    public function run(Environment $env, stdClass $value)
    {
        $array = array();

        foreach ($value->v as $value) {
            $array[] = $env->run($value);
        }

        return implode(' and ', $array);
    }
}