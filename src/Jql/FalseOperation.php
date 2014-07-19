<?php

namespace Jql;

class FalseOperation
{
    public function make()
    {
        $operation = new \stdClass();
        $operation->op = "false";
        return $operation;
    }

    public function run()
    {
        return false;
    }
}