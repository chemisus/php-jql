<?php

namespace Jql\Operations;

use Jql\AbstractContainerOperation;
use Jql\Environment;
use Jql\OperationContainer;

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