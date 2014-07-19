<?php

namespace Jql;

class MapOperation
{
    public function make($source, $apply)
    {
        $operation = new \stdClass();
        $operation->op = "map";
        $operation->source = $source;
        $operation->apply = $apply;
        return $operation;
    }

    public function run(Environment $environment, \stdClass $operation)
    {
        $values = array();

        foreach ($environment->run($operation->source) as $key => $value) {
            $environment->push($value, $key);

            $values[$key] = $environment->run($operation->apply);

            $environment->pop();
        }

        return $values;
    }
}