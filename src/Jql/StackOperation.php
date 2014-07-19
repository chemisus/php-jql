<?php

namespace Jql;

class StackOperation
{
    public function make($path)
    {
        $operation = new \stdClass();
        $operation->op = "stack";
        $operation->path = $path;
        return $operation;
    }

    public function run(Environment $environment, \stdClass $operation)
    {
        return $environment->get($environment->stack(), $environment->run($operation->path));
    }
}