<?php

namespace Jql;

use AbstractListOperation;
use Environment;

class JqlAndOperation extends AbstractListOperation
{
    public function __construct()
    {
        parent::__construct('and');
    }

    /**
     * @param Environment $env
     * @param  $term
     * @return mixed
     */
    public function run(Environment $env, $term)
    {
        foreach ($env->get($term, 'v') as $term) {
            if (!$env->run($term)) {
                return false;
            }
        }

        return true;
    }
}