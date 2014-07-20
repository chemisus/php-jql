<?php

namespace Sql\Operations;

use Sql\AbstractBinaryOperation;
use Sql\AbstractOperation;
use Sql\Environment;
use Sql\Method;
use Sql\Operation;

class ReduceOperation extends AbstractOperation
{
    /**
     * @var \Sql\Operation
     */
    private $records;

    /**
     * @var \Sql\Operation
     */
    private $initial;

    /**
     * @var \Sql\Method
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