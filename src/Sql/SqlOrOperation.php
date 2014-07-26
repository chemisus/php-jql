<?php

namespace Sql;

use Environment;
use stdClass;
use AbstractListOperation;

class SqlOrOperation extends AbstractListOperation
{
    public function __construct()
    {
        parent::__construct('or');
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

        return
            (!count($array) ? : '(') .
            implode(') or (', $array) .
            (!count($array) ? : ')');
    }
}