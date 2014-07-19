<?php

namespace Jql;

class MapOperation
{
    public function make($key, $source, $filter)
    {
        $operation = new \stdClass();
        $operation->op = "map";
        $operation->key = $key;
        $operation->source = $source;
        $operation->filter = $filter;
        return $operation;
    }

    public function run(Environment $environment, \stdClass $operation)
    {
        $values = array();

        foreach ($environment->run($operation->source) as $value) {
            $environment->push($operation->key, $value);

            if ($environment->run($operation->filter)) {
                $values[] = $value;
            }

            $environment->pop();
        }

        return $values;
    }
}