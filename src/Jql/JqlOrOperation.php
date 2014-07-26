<?php

namespace Jql;

use Environment;
use stdClass;
use AbstractListOperation;

class JqlOrOperation extends AbstractListOperation
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
        foreach ($value->v as $value) {
            if ($env->run($value)) {
                return true;
            }
        }

        return false;
    }
}