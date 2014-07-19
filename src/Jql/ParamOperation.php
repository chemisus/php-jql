<?php

namespace Jql;

class ParamOperation
{
    public function make($key)
    {
        $operation = new \stdClass();
        $operation->op = "param";
        $operation->key = $key;
        return $operation;
    }

    public function run(Environment $environment, \stdClass $operation)
    {
        return $environment->parameter($operation->key);
    }
}