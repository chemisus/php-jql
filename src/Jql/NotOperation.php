<?php

namespace Jql;

class NotOperation
{
    public function make($value)
    {
        $operation = new \stdClass();
        $operation->op = "not";
        $operation->value = $value;
        return $operation;
    }

    public function run(Environment $environment, \stdClass $operation)
    {
        return !$environment->run($operation->value);
    }
}