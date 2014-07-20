<?php

namespace Jql;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

class OperationContainer implements IteratorAggregate, Jsonable
{
    private $operations;

    /**
     * @param Operation[] $operations
     */
    public function __construct($operations)
    {
        $this->operations = $operations;
    }

    /**
     * @return mixed
     */
    public function toJson()
    {
        $array = array();

        foreach ($this->operations as $value) {
            $array[] = $value->toJson();
        }

        return $array;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     */
    public function getIterator()
    {
        return new ArrayIterator($this->operations);
    }
}