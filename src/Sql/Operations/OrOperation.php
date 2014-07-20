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
        foreach ($this->values() as $value) {
            if ($value->run($environment)) {
                return true;
            }
        }

        return false;
    }
}