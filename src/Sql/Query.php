<?php

namespace Sql;

use Sql\Methods\AddMethod;
use Sql\Operations\AndOperation;
use Sql\Operations\ConstantOperation;
use Sql\Operations\EqualOperation;
use Sql\Operations\FalseOperation;
use Sql\Operations\FilterOperation;
use Sql\Operations\MapOperation;
use Sql\Operations\NotOperation;
use Sql\Operations\ObjectOperation;
use Sql\Operations\OrOperation;
use Sql\Operations\ParamOperation;
use Sql\Operations\ReduceOperation;
use Sql\Operations\SelectOperation;
use Sql\Operations\TableOperation;
use Sql\Operations\TrueOperation;

class Query
{
    /**
     * @param $value
     * @return EntityOperation
     */
    public function entity($value)
    {
        return new EntityOperation($value);
    }

    /**
     * @return TrueOperation
     */
    public function true()
    {
        return new TrueOperation();
    }

    /**
     * @return FalseOperation
     */
    public function false()
    {
        return new FalseOperation();
    }

    /**
     * @param Operation $lhs
     * @param Operation $rhs
     * @return EqualOperation
     */
    public function equal(Operation $lhs, Operation $rhs)
    {
        return new EqualOperation($lhs, $rhs);
    }

    /**
     * @param Operation $value
     * @return NotOperation
     */
    public function not(Operation $value)
    {
        return new NotOperation($value);
    }

    /**
     * @param mixed $value
     * @return ConstantOperation
     */
    public function constant($value)
    {
        return new ConstantOperation($value);
    }

    /**
     * @param OperationContainer $values
     * @return AndOperation
     */
    public function ands(OperationContainer $values)
    {
        return new AndOperation($values);
    }

    /**
     * @param OperationContainer $values
     * @return OrOperation
     */
    public function ors(OperationContainer $values)
    {
        return new OrOperation($values);
    }

    /**
     * @param Operation $records
     * @param Operation $callback
     * @return MapOperation
     */
    public function map(Operation $records, Operation $callback)
    {
        return new MapOperation($records, $callback);
    }

    /**
     * @param Operation $records
     * @param Operation $method
     * @return MapOperation
     */
    public function filter(Operation $records, Operation $method)
    {
        return new FilterOperation($records, $method);
    }

    /**
     * @param Operation $records
     * @param Operation $initial
     * @param Method $method
     * @return ReduceOperation
     */
    public function reduce(Operation $records, Operation $initial, Method $method)
    {
        return new ReduceOperation($records, $initial, $method);
    }

    /**
     * @param OperationContainer $values
     * @return ObjectOperation
     */
    public function object(OperationContainer $values)
    {
        return new ObjectOperation($values);
    }

    /**
     * @param OperationContainer $fields
     * @param Operation $from
     * @param OperationContainer $joins
     * @param Operations\OrOperation $where
     * @return SelectOperation
     */
    public function select(OperationContainer $fields, Operation $from, OperationContainer $joins, OrOperation $where)
    {
        return new SelectOperation($fields, $from, $joins, $where);
    }

    public function table($name)
    {
        return new TableOperation($name);
    }

    /**
     * @param $key
     * @return ParamOperation
     */
    public function param($key)
    {
        return new ParamOperation($key);
    }

    /**
     * @return AddMethod
     */
    public function add()
    {
        return new AddMethod();
    }

//    public function run($operation, $parameters = array(), Database $database = null)
//    {
//        $environment = new Environment($this->operations, $parameters, $database);
//
//        return $environment->run($operation);
//    }
}