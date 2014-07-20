<?php

namespace Sql\Operations;

use Sql\AbstractContainerOperation;
use Sql\Environment;
use Sql\OperationContainer;

class AndOperation extends AbstractContainerOperation
{
    /**
     * @param OperationContainer $values
     */
    public function __construct(OperationContainer $values)
    {
        parent::__construct('and', $values);
    }

    public function run(Environment $environment)
    {
        foreach ($this->values() as $value) {
            if (!$value->run($environment)) {
                return false;
            }
        }

        return true;
    }
}