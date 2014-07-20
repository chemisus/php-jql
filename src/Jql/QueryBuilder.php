<?php

namespace Jql;

use Jql\Operations\AndOperation;
use Jql\Operations\EqualOperation;
use Jql\Operations\FalseOperation;
use Jql\Operations\NotOperation;
use Jql\Operations\OrOperation;
use Jql\Operations\TrueOperation;

class QueryBuilder
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

//    public function run($operation, $parameters = array(), Database $database = null)
//    {
//        $environment = new Environment($this->operations, $parameters, $database);
//
//        return $environment->run($operation);
//    }
}