<?php

namespace Sql;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

class OperationContainer implements IteratorAggregate, Operation
{
    private $operations = array();

    /**
     * @param Operation[] $operations
     */
    public function __construct(array $operations)
    {
        foreach ($operations as $operation) {
            $this->add($operation);
        }
    }

    public function add(Operation $operation)
    {
        $this->operations[] = $operation;
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

    public function run(Environment $environment)
    {
        $array = array();

        foreach ($this->operations as $value) {
            $array[] = $value->run($environment);
        }

        return $array;
    }
}