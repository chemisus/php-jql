<?php

namespace Jql;

use AbstractListOperation;
use Environment;


class JqlOrOperation extends AbstractListOperation
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
        foreach ($env->get($term, 'v') as $term) {
            if ($env->run($term)) {
                return true;
            }
        }

        return false;
    }
}