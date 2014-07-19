<?php

namespace Jql;

class OrsOperation
{
    public function make($values)
    {
        $operation = new \stdClass();
        $operation->op = "or";
        $operation->values = $values;
        return $operation;
    }

    public function run(Environment $environment, \stdClass $operation)
    {
        foreach ($operation->values as $value) {
            if ($environment->run($value)) {
                return true;
            }
        }

        return false;
    }
}