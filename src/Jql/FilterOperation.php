<?php

namespace Jql;

class FilterOperation
{
    public function make($source, $filter)
    {
        $operation = new \stdClass();
        $operation->op = "filter";
        $operation->source = $source;
        $operation->filter = $filter;
        return $operation;
    }

    public function run(Environment $environment, \stdClass $operation)
    {
        $values = array();

        foreach ($environment->run($operation->source) as $value) {
            $environment->push($value);

            if ($environment->run($operation->filter)) {
                $values[] = $value;
            }

            $environment->pop();
        }

        return $values;
    }
}