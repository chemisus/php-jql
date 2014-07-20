<?php

namespace Sql\Operations;

use Sql\AbstractBinaryOperation;
use Sql\Environment;
use Sql\Operation;

class MapOperation extends AbstractBinaryOperation
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

            $array[] = $this->b()->run($environment);

            $environment->pop();
        }

        return $array;
    }
}