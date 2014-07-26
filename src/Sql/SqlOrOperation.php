<?php

namespace Sql;

use AbstractListOperation;
use Environment;


class SqlOrOperation extends AbstractListOperation
{
    public function __construct()
    {
        parent::__construct('or');
    }

    /**
     * @param Environment $env
     * @param  $term
     * @return mixed
     */
    public function run(Environment $env, $term)
    {
        $array = array();

        foreach ($env->get($term, 'v') as $term) {
            $array[] = $env->run($term);
        }

        return
            (!count($array) ? : '(') .
            implode(') or (', $array) .
            (!count($array) ? : ')');
    }
}