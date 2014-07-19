<?php

namespace Jql;

class KeyOperation
{
    public function make()
    {
        $operation = new \stdClass();
        $operation->op = "key";
        return $operation;
    }

    public function run(Environment $environment, \stdClass $operation)
    {
        return $environment->key();
    }
}