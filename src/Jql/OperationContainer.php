<?php

namespace Jql;

class OperationContainer implements \ArrayAccess
{
    private $operations;

    public function __get($key)
    {
        return $this->operations[$key];
    }

    public function __construct()
    {
        $this->operations = array(
            'true' => new TrueOperation(),
            'false' => new FalseOperation(),
            'equal' => new EqualOperation(),
            'not' => new NotOperation(),
            'and' => new AndsOperation(),
            'or' => new OrsOperation(),
            'const' => new ConstOperation(),
            'param' => new ParamOperation(),
            'filter' => new FilterOperation(),
            'get' => new GetOperation(),
            'current' => new CurrentOperation(),
        );
    }

    public function offsetExists($offset)
    {
        return array_key_exists($this->operations, $offset);
    }

    public function offsetGet($offset)
    {
        return $this->operations[$offset];
    }

    public function offsetSet($offset, $value)
    {
    }

    public function offsetUnset($offset)
    {
    }
}