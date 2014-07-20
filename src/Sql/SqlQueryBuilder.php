<?php

namespace Sql;

class SqlQueryBuilder implements ArrayAccess, IteratorAggregate, Query
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getIterator()
    {
        return new ResultSetIterator($this->evaluate());
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

    public function execute()
    {
        return $this->query->execute();
    }
}