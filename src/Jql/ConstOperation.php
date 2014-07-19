<?php

namespace Jql;

class ConstOperation
{
    public function make($value)
    {
        $operation = new \stdClass();
        $operation->op = "const";
        $operation->value = $value;
        return $operation;
    }

    public function run(Environment $environment, \stdClass $operation)
    {
        return $operation->value;
    }
}