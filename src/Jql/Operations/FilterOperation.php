<?php

namespace Jql\Operations;

use Jql\AbstractBinaryOperation;
use Jql\Environment;
use Jql\Operation;

class FilterOperation extends AbstractBinaryOperation
{
    public function __construct(Operation $records, Operation $callback)
    {
        parent::__construct('map', $records, $callback, 'records', 'callback');
    }

    public function run(Environment $environment)
    {
        $array = array();

        foreach ($this->a()->run($environment) as $key => $value) {
            $environment->push($key, $value);

            if ($this->b()->run($environment)) {
                $array[] = $value;
            }

            $environment->pop();
        }

        return $array;
    }
}