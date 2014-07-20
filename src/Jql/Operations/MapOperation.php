<?php

namespace Jql\Operations;

use Jql\AbstractBinaryOperation;
use Jql\Environment;
use Jql\Operation;

class MapOperation extends AbstractBinaryOperation
{
    public function __construct(Operation $lhs, Operation $rhs)
    {
        parent::__construct('map', $lhs, $rhs);
    }

    public function run(Environment $environment)
    {
        $array = array();

        foreach ($this->lhs()->run($environment) as $key => $value) {
            $environment->push($key, $value);

            $array[] = $this->rhs()->run($environment);

            $environment->pop();
        }

        return $array;
    }
}