<?php

namespace Jql;

class Environment
{
    private $database;
    private $operations;
    private $parameters;
    private $stack = array();

    public function __construct(OperationContainer $operations, array $parameters = array(), Database $database = null)
    {
        $this->database = $database;
        $this->operations = $operations;
        $this->parameters = $parameters;
    }

    public function table($name)
    {
        return $this->database->table($name);
    }

    public function parameter($key)
    {
        return $this->parameters[$key];
    }

    public function run($operation)
    {
        return $this->operations[$operation->op]->run($this, $operation);
    }

    public function push($value, $key = null)
    {
        $this->stack[] = array($value, $key);
    }

    public function pop()
    {
        array_pop($this->stack);
    }

    public function stack()
    {
        return $this->stack;
    }

    public function key()
    {
        $keys = array_keys($this->stack);

        return $this->stack[array_pop($keys)][1];
    }

    public function current()
    {
        $keys = array_keys($this->stack);

        return $this->stack[array_pop($keys)][0];
    }

    public function get($value, $path)
    {
        $path = trim($path);

        if (!$path) {
            return $value;
        }

        $keys = explode('.', $path);

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
