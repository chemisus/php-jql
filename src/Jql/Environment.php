<?php

namespace Jql;

use SebastianBergmann\Exporter\Exception;

class Environment
{
    private $operations;
    private $parameters;
    private $stack = array();

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

    public function push($key, $value)
    {
//        array_push($this->stack, array($key, $value));
        $this->stack[$key] = $value;
    }

    public function pop()
    {
        array_pop($this->stack);
    }

    public function get($path)
    {
        $keys = explode('.', $path);

        $value = $this->stack;

        while (count($keys)) {
            $key = array_shift($keys);

            if (is_object($value)) {
                $value = $value->{$key};
            } else if (is_array($value)) {
                $value = $value[$key];
            } else {
                throw new \Exception();
            }
        }

        return $value;
    }
}
