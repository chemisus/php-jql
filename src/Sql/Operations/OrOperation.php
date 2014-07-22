<?php

namespace Sql\Operations;

use Sql\AbstractContainerOperation;
use Sql\Environment;
use Sql\OperationContainer;

class OrOperation extends AbstractContainerOperation
{
    /**
     * @param OperationContainer $values
     */
    public function __construct(OperationContainer $values)
    {
        parent::__construct('or', $values);
    }

    public function run(Environment $environment)
    {
        return '(' . implode(')||(' , $this->values()->run($environment)) . ')';
    }
}