<?php

namespace Jql;

class GetOperation
{
    public function make($path)
    {
        $operation = new \stdClass();
        $operation->op = "get";
        $operation->path = $path;
        return $operation;
    }

    public function run(Environment $environment, \stdClass $operation)
    {
        return $environment->get($operation->path);
    }
}