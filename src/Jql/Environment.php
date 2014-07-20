<?php

namespace Jql;

class Environment
{
    private $database;
    private $parameters;

    private $keys = array();
    private $values = array();

    public function __construct(Database $database = null, array $parameters = array())
    {
        $this->database = $database;
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

    public function push($key, $value)
    {
        array_push($this->keys, $key);
        array_push($this->values, $value);
    }

    public function pop()
    {
        array_pop($this->keys);
        array_pop($this->values);
    }

    public function stack()
    {
        return $this->values;
    }

    public function key()
    {
        $keys = array_values($this->keys);

        return array_pop($keys);
    }

    public function current()
    {
        $values = array_values($this->values);

        return array_pop($values);
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
