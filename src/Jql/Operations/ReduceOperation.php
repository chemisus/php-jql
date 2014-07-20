<?php

namespace Jql\Operations;

use Jql\AbstractBinaryOperation;
use Jql\AbstractOperation;
use Jql\Environment;
use Jql\Method;
use Jql\Operation;

class ReduceOperation extends AbstractOperation
{
    /**
     * @var \Jql\Operation
     */
    private $records;

    /**
     * @var \Jql\Operation
     */
    private $initial;

    /**
     * @var \Jql\Method
     */
    private $method;

    /**
     * @param Operation $records
     * @param Operation $initial
     * @param Method $method
     */
    public function __construct(Operation $records, Operation $initial, Method $method)
    {
        parent::__construct('map');

        $this->records = $records;
        $this->initial = $initial;
        $this->method = $method;
    }

    public function run(Environment $environment)
    {
        $current = $this->initial->run($environment);

        foreach ($this->records->run($environment) as $key => $value) {
            $environment->push($key, $value);

            $current = $this->method->call($environment, $current);

            $environment->pop();
        }

        return $current;
    }
}