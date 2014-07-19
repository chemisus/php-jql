<?php

namespace Jql;

class TrueOperation
{
    public function make()
    {
        $operation = new \stdClass();
        $operation->op = "true";
        return $operation;
    }

    public function run()
    {
        return true;
    }
}