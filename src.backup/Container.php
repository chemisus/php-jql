<?php

class Container implements ArrayAccess, IteratorAggregate, Countable
{
    private $values = array();
    private $templates;

    public function __construct($values = array(), $templates = array())
    {
        if ($values instanceof Container) {
            $values = $values->toArray();
        }

        $this->templates = (array)$templates;
        $this->values = (array)$values;
        $this->verifyContainer($this->templates);
    }

    public function count()
    {
        return count($this->values);
    }

    public function add($value)
    {
        $this->verifyTemplates($value, $this->templates);

        $this->values[] = $value;

        return key(array_slice($this->values, -1, 1, true));
    }

    public function missingTemplates($value, $templates)
    {
        $missing = array();

        $primitives = array(
            'string' => 'is_string',
            'integer' => 'is_integer',
            'int' => 'is_int',
            'array' => 'is_array',
            'object' => 'is_object',
            'bool' => 'is_bool',
            'boolean' => 'is_bool',
            'callable' => 'is_callable',
            'double' => 'is_double',
            'long' => 'is_long',
        );

        foreach ((array)$templates as $template) {
            if (array_key_exists($template, $primitives)) {
                if (!call_user_func($primitives[$template], $value)) {
                    $missing[] = $template;
                }
            } else if (!$value instanceof $template) {
                $missing[] = $template;
            }
        }

        return $missing;
    }

    public function verifyTemplates($value, $templates = array())
    {
        if ($missing = $this->missingTemplates($value, $templates)) {
            throw new Exception("Value is not an instance of " . implode(', ', $missing) . ".");
        }
    }

    public function verifyContainer($templates = array())
    {
        foreach ($this->values as $value) {
            $this->verifyTemplates($value, $templates);
        }
    }

    public function getIterator()
    {
        return new ArrayIterator($this->values);
    }

    public function offsetExists($offset)
    {
    }

    public function offsetGet($offset)
    {
    }

    public function offsetSet($offset, $value)
    {
    }

    public function offsetUnset($offset)
    {
    }

    public function map($callback, $templates = array())
    {
        $result = array();

        foreach ($this as $key => $value) {
            $result[$key] = call_user_func($callback, $value, $key);
        }

        return new Container($result);
    }

    public function reduce($initial, $callback, $templates = array())
    {
        $result = $initial;

        foreach ($this as $key => $value) {
            $result = call_user_func($callback, $result, $value, $key);
        }

        return $result;
    }

    public function filter($callback, $keep_keys = false)
    {
        $result = array();

        foreach ($this as $key => $value) {
            if (call_user_func($callback, $value, $key)) {
                if ($keep_keys) {
                    $result[$key] = $value;
                } else {
                    $result[] = $value;
                }
            }
        }

        return new Container($result);
    }

    public function each($method, array $parameters = array(), $templates = array())
    {
        return $this->map(function ($value) use ($method, $parameters) {
            return call_user_func_array(array($value, $method), $parameters);
        }, $templates);
    }

    public function implode($glue, $prefix = '', $suffix = '', $switch = true)
    {
        return
            (!$switch ? : $prefix) .
            implode($glue, $this->values) .
            (!$switch ? : $suffix);
    }

    public function toArray()
    {
        return $this->values;
    }
}