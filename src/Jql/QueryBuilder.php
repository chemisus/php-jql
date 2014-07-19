<?php

namespace Jql;

class QueryBuilder
{
    private $operations;

    public function __construct(OperationContainer $operations)
    {
        $this->operations = $operations;
    }

    public function run($operation, $parameters = array())
    {
        $environment = new Environment($this->operations, $parameters);

        return $environment->run($operation);
    }

    public function __call($method, array $values)
    {
        return call_user_func_array(array($this->operations[$method], 'make'), $values);
    }
}