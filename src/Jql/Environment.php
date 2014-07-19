<?php

namespace Jql;

class Environment
{
    private $operations;
    private $parameters;

    public function __construct(OperationContainer $operations, array $parameters)
    {
        $this->operations = $operations;
        $this->parameters = $parameters;
    }

    public function parameter($key)
    {
        return $this->parameters[$key];
    }

    public function run($operation)
    {
        return $this->operations[$operation->op]->run($this, $operation);
    }
}
