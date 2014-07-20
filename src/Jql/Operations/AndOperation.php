<?php

namespace Jql\Operations;

use Jql\AbstractContainerOperation;
use Jql\Environment;
use Jql\OperationContainer;

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