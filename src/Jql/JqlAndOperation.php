<?php

namespace Jql;

use Environment;
use stdClass;
use AbstractListOperation;

class JqlAndOperation extends AbstractListOperation
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
        foreach ($value->v as $value) {
            if (!$env->run($value)) {
                return false;
            }
        }

        return true;
    }
}