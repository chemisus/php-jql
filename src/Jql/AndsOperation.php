<?php

namespace Jql;

class AndsOperation
{
    public function make($values)
    {
        $operation = new \stdClass();
        $operation->op = "and";
        $operation->values = $values;
        return $operation;
    }

    public function run(Environment $environment, \stdClass $operation)
    {
        foreach ($operation->values as $value) {
            if (!$environment->run($value)) {
                return false;
            }
        }

        return true;
    }
}