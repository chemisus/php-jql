<?php

namespace Jql;

class CurrentOperation
{
    public function make($path)
    {
        $operation = new \stdClass();
        $operation->op = "current";
        $operation->path = $path;
        return $operation;
    }

    public function run(Environment $environment, \stdClass $operation)
    {
        return $environment->get($environment->current(), $environment->run($operation->path));
    }
}