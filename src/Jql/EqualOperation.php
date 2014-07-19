<?php

namespace Jql;

class EqualOperation
{
    public function make($lhs, $rhs)
    {
        $operation = new \stdClass();
        $operation->op = "equal";
        $operation->lhs = $lhs;
        $operation->rhs = $rhs;
        return $operation;
    }

    public function run(Environment $environment, \stdClass $operation)
    {
        return $environment->run($operation->lhs) === $environment->run($operation->rhs);
    }
}