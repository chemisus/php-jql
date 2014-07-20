<?php

namespace Jql;

use Jql\Methods\AddMethod;
use Jql\Operations\AndOperation;
use Jql\Operations\ConstantOperation;
use Jql\Operations\EqualOperation;
use Jql\Operations\FalseOperation;
use Jql\Operations\FilterOperation;
use Jql\Operations\MapOperation;
use Jql\Operations\NotOperation;
use Jql\Operations\ObjectOperation;
use Jql\Operations\OrOperation;
use Jql\Operations\ReduceOperation;
use Jql\Operations\SelectOperation;
use Jql\Operations\TableOperation;
use Jql\Operations\TrueOperation;

class Query
{
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
     * @param Operation $value
     * @return SelectOperation
     */
    public function select(Operation $value)
    {
        return new SelectOperation($value);
    }

    public function table($name)
    {
        return new TableOperation($name);
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